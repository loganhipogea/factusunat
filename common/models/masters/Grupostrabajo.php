<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "grupostrabajo".
 *
 * @property string $codgrupo
 * @property string|null $desgrupo
 * @property string|null $detalle
 */
class Grupostrabajo extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupostrabajo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codgrupo'], 'required'],
            [['detalle'], 'string'],
            [['codgrupo'], 'string', 'max' => 5],
            [['desgrupo'], 'string', 'max' => 40],
            [['codgrupo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codgrupo' => Yii::t('app', 'Codgrupo'),
            'desgrupo' => Yii::t('app', 'Desgrupo'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return GrupostrabajoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GrupostrabajoQuery(get_called_class());
    }
}
