<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%vw_turnos_asignaciones}}".
 *
 * @property int $id
 * @property int|null $cuadrilla_id
 * @property string|null $codcuadrilla_id
 * @property int|null $trabajador_id
 * @property string|null $codtra_id
 * @property int|null $turno_id
 * @property string|null $textodetalle
 * @property int $idcuadrilla
 * @property string|null $codcuadrilla
 * @property string|null $descricuadrilla
 * @property string $codigotra
 * @property string $nombres
 * @property string $codarea
 * @property string|null $desarea
 * @property string|null $desturno
 * @property string|null $fecha
 * @property string|null $actiasignado
 */
class VwTurnosAsignaciones extends \common\models\base\modelBase
{
    
    
    public $booleanFields=['actiasignado'];
     public $dateorTimeFields = [
        'finicio' => self::_FDATETIME, 
       'fin' => self::_FDATETIME, 
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_turnos_asignaciones}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cuadrilla_id', 'trabajador_id', 'turno_id', 'idcuadrilla'], 'integer'],
            [['textodetalle'], 'string'],
            [['codigotra', 'codarea'], 'required'],
            [['codcuadrilla_id', 'codcuadrilla'], 'string', 'max' => 14],
            [['codtra_id', 'codigotra'], 'string', 'max' => 6],
            [['descricuadrilla'], 'string', 'max' => 80],
            [['nombres'], 'string', 'max' => 81],
            [['codarea'], 'string', 'max' => 4],
            [['desarea', 'desturno'], 'string', 'max' => 40],
            [['fecha'], 'string', 'max' => 10],
            //[['actiasignado'], 'string', 'max' => 1],
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
            'turno_id' => Yii::t('app', 'Turno ID'),
            'textodetalle' => Yii::t('app', 'Textodetalle'),
            'idcuadrilla' => Yii::t('app', 'Idcuadrilla'),
            'codcuadrilla' => Yii::t('app', 'Codcuadrilla'),
            'descricuadrilla' => Yii::t('app', 'Descricuadrilla'),
            'codigotra' => Yii::t('app', 'Codigotra'),
            'nombres' => Yii::t('app', 'Nombres'),
            'codarea' => Yii::t('app', 'Codarea'),
            'desarea' => Yii::t('app', 'Desarea'),
            'desturno' => Yii::t('app', 'Desturno'),
            'fecha' => Yii::t('app', 'Fecha'),
            'actiasignado' => Yii::t('app', 'Actiasignado'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwTurnosAsignacionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwTurnosAsignacionesQuery(get_called_class());
    }
    
     public function getAsignacion(){
    
        return $this->hasOne(Turnosasignaciones::className(), ['id' => 'id']);
   
    }
}
