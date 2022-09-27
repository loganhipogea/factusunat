<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sustancia".
 *
 * @property int $id
 * @property string|null $descripcion
 * @property float|null $densidad
 * @property float|null $dureza
 */
class Sustancia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sustancia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['densidad', 'dureza'], 'number'],
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
            'descripcion' => Yii::t('app', 'Descripcion'),
            'densidad' => Yii::t('app', 'Densidad (Kg/m3)'),
            'dureza' => Yii::t('app', 'Dureza'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SustanciaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SustanciaQuery(get_called_class());
    }
}
