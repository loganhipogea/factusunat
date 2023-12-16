<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%resef_partedetplan}}".
 *
 * @property int $id
 * @property int|null $parte_id
 * @property int|null $orden_id
 * @property int|null $area_id
 * @property string|null $hinicio
 * @property string|null $hfin
 * @property string|null $actividad
 */
class ResefParteDetPlan extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%resef_partedetplan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parte_id', 'orden_id', 'area_id'], 'integer'],
            [['hinicio', 'hfin'], 'string', 'max' => 5],
            [['actividad'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parte_id' => Yii::t('app', 'Parte ID'),
            'orden_id' => Yii::t('app', 'Orden ID'),
            'area_id' => Yii::t('app', 'Area ID'),
            'hinicio' => Yii::t('app', 'Hinicio'),
            'hfin' => Yii::t('app', 'Hfin'),
            'actividad' => Yii::t('app', 'Actividad'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ResefPartesDetPlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResefPartesDetPlanQuery(get_called_class());
    }
}
