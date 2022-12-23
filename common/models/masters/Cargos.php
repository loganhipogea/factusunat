<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "cargos".
 *
 * @property int $id
 * @property string|null $descricargo
 * @property string|null $codcargo
 * @property float|null $hh
 */
class Cargos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cargos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hh'], 'number'],
            [['descricargo'], 'string', 'max' => 40],
            [['codcargo'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descricargo' => Yii::t('app', 'Descricargo'),
            'codcargo' => Yii::t('app', 'Codcargo'),
            'hh' => Yii::t('app', 'Hh'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CargosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CargosQuery(get_called_class());
    }
}
