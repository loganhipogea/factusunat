<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "resef_areas".
 *
 * @property int $id
 * @property string|null $nombre
 */
class ResefAreas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resef_areas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ResefAreasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResefAreasQuery(get_called_class());
    }
}
