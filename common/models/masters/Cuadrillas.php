<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "cuadrillas".
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $codarea_id
 * @property string|null $codgrupo_id
 * @property string|null $descripcion
 * @property string|null $textodetalle
 */
class Cuadrillas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuadrillas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['textodetalle'], 'string'],
            [['codigo', 'codgrupo_id'], 'string', 'max' => 14],
              [['codigo'], 'unique'],
            [['codarea_id'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'codarea_id' => Yii::t('app', 'Codarea ID'),
            'codgrupo_id' => Yii::t('app', 'Codgrupo ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'textodetalle' => Yii::t('app', 'Textodetalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CuadrillasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CuadrillasQuery(get_called_class());
    }
}
