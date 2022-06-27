<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%com_cajadia}}".
 *
 * @property int $id
 * @property int|null $caja_id
 * @property string|null $fecha
 * @property float|null $monto_papel
 * @property float|null $monto_efectivo
 * @property float|null $diferencia
 * @property string|null $estado
 *
 * @property ComCajaventa $caja
 */
class ComCajadia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
    public $dateOrTimeFields=[
        'fecha'=>self::_FDATE
    ];
    public static function tableName()
    {
        return '{{%com_cajadia}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caja_id'], 'integer'],
            [['monto_papel', 'monto_efectivo', 'diferencia'], 'number'],
            [['fecha'], 'string', 'max' => 10],
            [['estado'], 'string', 'max' => 1],
            [['fecha','caja_id'], 'unique', 'targetAttribute' =>['fecha','caja_id'] ],
            [['caja_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComCajaventa::className(), 'targetAttribute' => ['caja_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'caja_id' => Yii::t('base.names', 'Caja ID'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'monto_papel' => Yii::t('base.names', 'Monto Papel'),
            'monto_efectivo' => Yii::t('base.names', 'Monto Efectivo'),
            'diferencia' => Yii::t('base.names', 'Diferencia'),
            'estado' => Yii::t('base.names', 'Estado'),
        ];
    }

    /**
     * Gets query for [[Caja]].
     *
     * @return \yii\db\ActiveQuery|ComCajaventaQuery
     */
    public function getCaja()
    {
        return $this->hasOne(ComCajaventa::className(), ['id' => 'caja_id']);
    }

    /**
     * {@inheritdoc}
     * @return ComCajadiaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCajadiaQuery(get_called_class());
    }
}
