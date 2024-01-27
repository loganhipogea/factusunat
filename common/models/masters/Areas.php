<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property string $codarea
 * @property string|null $desarea
 * @property string|null $detalle
 */
class Areas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codarea'], 'required'],
            [['detalle'], 'string'],
            [['codarea'], 'string', 'max' => 4],
            [['desarea'], 'string', 'max' => 40],
            [['codarea'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codarea' => Yii::t('app', 'Codarea'),
            'desarea' => Yii::t('app', 'Desarea'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AreasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreasQuery(get_called_class());
    }
}
