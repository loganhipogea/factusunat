<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_reserva}}".
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $numero
 * @property string|null $detalle
 * @property string|null $codocuref
 * @property string|null $numdocref
 */
class MatReserva extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_reserva}}';
    }
    
    public $dateOrTimeFields=['fecha'=>self::_FDATE];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalle'], 'string'],
            [['fecha'], 'string', 'max' => 10],
            [['numero'], 'string', 'max' => 14],
            [['codocuref'], 'string', 'max' => 3],
            [['numdocref'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'numero' => Yii::t('base.names', 'Numero'),
            'detalle' => Yii::t('base.names', 'Detalle'),
            'codocuref' => Yii::t('base.names', 'Codocuref'),
            'numdocref' => Yii::t('base.names', 'Numdocref'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatReservaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatReservaQuery(get_called_class());
    }
}
