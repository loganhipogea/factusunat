<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_detguia}}".
 *
 * @property int $id
 * @property int $guia_id
 * @property string|null $item
 * @property string|null $codum
 * @property float $cant
 * @property string|null $codart
 * @property string|null $codaf
 * @property string|null $serie
 * @property string|null $descripcion
 * @property string|null $detalle
 */
class MatDetGuia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detguia}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guia_id', 'cant'], 'required'],
            [['guia_id'], 'integer'],
            [['cant'], 'number'],
            [['detalle'], 'string'],
            [['item'], 'string', 'max' => 3],
            [['codum'], 'string', 'max' => 4],
            [['codart', 'codaf'], 'string', 'max' => 14],
            [['serie'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'guia_id' => Yii::t('app', 'Guia ID'),
            'item' => Yii::t('app', 'Item'),
            'codum' => Yii::t('app', 'Codum'),
            'cant' => Yii::t('app', 'Cant'),
            'codart' => Yii::t('app', 'Codart'),
            'codaf' => Yii::t('app', 'Codaf'),
            'serie' => Yii::t('app', 'Serie'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatDetGuiaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetGuiaQuery(get_called_class());
    }
    
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuia()
    {
        return $this->hasOne(Matguia::className(), ['codart' => 'codart']);
    }
    
}
