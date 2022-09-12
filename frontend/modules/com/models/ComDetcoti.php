<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "com_detcoti".
 *
 * @property int $id
 * @property int|null $coti_id
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
 * @property ComCotizacione $coti
 */
class ComDetcoti extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'com_detcoti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coti_id'], 'integer'],
            [['detalle'], 'string'],
            [['cant', 'punit', 'ptotal', 'igv', 'pventa'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
            [['coti_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComCotizacione::className(), 'targetAttribute' => ['coti_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'coti_id' => Yii::t('app', 'Coti ID'),
            'item' => Yii::t('app', 'Item'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codart' => Yii::t('app', 'Codart'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codum' => Yii::t('app', 'Codum'),
            'cant' => Yii::t('app', 'Cant'),
            'punit' => Yii::t('app', 'Punit'),
            'ptotal' => Yii::t('app', 'Ptotal'),
            'igv' => Yii::t('app', 'Igv'),
            'pventa' => Yii::t('app', 'Pventa'),
        ];
    }

    /**
     * Gets query for [[Coti]].
     *
     * @return \yii\db\ActiveQuery|ComCotizacioneQuery
     */
    public function getCoti()
    {
        return $this->hasOne(ComCotizacione::className(), ['id' => 'coti_id']);
    }

    /**
     * {@inheritdoc}
     * @return ComDetcotiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComDetcotiQuery(get_called_class());
    }
}
