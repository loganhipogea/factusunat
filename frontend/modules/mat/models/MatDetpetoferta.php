<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "mat_detpetoferta".
 *
 * @property int $id
 * @property int|null $petoferta_id
 * @property string|null $item
 * @property string|null $tipo tipo material o servicio
 * @property string|null $codart
 * @property string|null $descripcion
 * @property string|null $detalle
 * @property string|null $codum
 * @property float|null $cant
 * @property float|null $punit
 * @property float|null $ptotal
 * @property float|null $igv
 * @property float|null $pventa
 *
 * @property MatPetofertum $petoferta
 */
class MatDetpetoferta extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detpetoferta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petoferta_id'], 'integer'],
             [['codart'], 'required'],
            [['detalle'], 'string'],
             [['codum'], 'string', 'max' => 3],
            [['cant', 'punit', 'ptotal', 'igv', 'pventa'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
            [['codart'], 'exist', 'skipOnError' => false, 'targetClass' => \common\models\masters\Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
            [['petoferta_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatPetoferta::className(), 'targetAttribute' => ['petoferta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'petoferta_id' => Yii::t('app', 'Petoferta ID'),
            'item' => Yii::t('app', 'Item'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codart' => Yii::t('app', 'Codart'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            //'codum' => Yii::t('app', 'Codum'),
            'cant' => Yii::t('app', 'Cant'),
            'punit' => Yii::t('app', 'Punit'),
            'ptotal' => Yii::t('app', 'Ptotal'),
            'igv' => Yii::t('app', 'Igv'),
            'pventa' => Yii::t('app', 'Pventa'),
        ];
    }

    /**
     * Gets query for [[Petoferta]].
     *
     * @return \yii\db\ActiveQuery|MatPetofertumQuery
     */
    public function getPetoferta()
    {
        return $this->hasOne(MatPetoferta::className(), ['id' => 'petoferta_id']);
    }
    
     public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }

    /**
     * {@inheritdoc}
     * @return MatDetpetofertaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetpetofertaQuery(get_called_class());
    }
}
