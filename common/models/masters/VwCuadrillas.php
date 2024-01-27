<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "vw_cuadrillas".
 *
 * @property int $id
 * @property int|null $cuadrilla_id
 * @property string|null $codcuadrilla_id
 * @property int|null $trabajador_id
 * @property string|null $codtra_id
 * @property string|null $textodetalle
 * @property int $idcuadrilla
 * @property string|null $codcuadrilla
 * @property string|null $descricuadrilla
 * @property string $codigotra
 * @property string $nombres
 * @property string $codarea
 * @property string|null $desarea
 */
class VwCuadrillas extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_cuadrillas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cuadrilla_id', 'trabajador_id', 'idcuadrilla'], 'integer'],
            [['textodetalle'], 'string'],
            [['codigotra', 'codarea'], 'required'],
            [['codcuadrilla_id', 'codcuadrilla'], 'string', 'max' => 14],
            [['codtra_id', 'codigotra'], 'string', 'max' => 6],
            [['descricuadrilla'], 'string', 'max' => 80],
            [['nombres'], 'string', 'max' => 81],
            [['codarea'], 'string', 'max' => 4],
            [['desarea'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cuadrilla_id' => Yii::t('app', 'Cuadrilla ID'),
            'codcuadrilla_id' => Yii::t('app', 'Codcuadrilla ID'),
            'trabajador_id' => Yii::t('app', 'Trabajador ID'),
            'codtra_id' => Yii::t('app', 'Codtra ID'),
            'textodetalle' => Yii::t('app', 'Textodetalle'),
            'idcuadrilla' => Yii::t('app', 'Idcuadrilla'),
            'codcuadrilla' => Yii::t('app', 'Codcuadrilla'),
            'descricuadrilla' => Yii::t('app', 'Descricuadrilla'),
            'codigotra' => Yii::t('app', 'Codigotra'),
            'nombres' => Yii::t('app', 'Nombres'),
            'codarea' => Yii::t('app', 'Codarea'),
            'desarea' => Yii::t('app', 'Desarea'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwCuadrillasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwCuadrillasQuery(get_called_class());
    }
}
