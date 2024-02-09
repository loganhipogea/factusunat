<?php

namespace common\models\masters;

use Yii;

/**
 * This is the model class for table "{{%turnoscambio}}".
 *
 * @property int $id
 * @property int|null $turnosasignaciones_id
 * @property string|null $descripcion
 * @property string|null $detalles
 * @property int|null $ingreso
 * @property string|null $codocuref
 * @property string|null $numdocuref
 * @property string|null $codmotivo
 * @property string|null $fecha
 */
class Turnoscambio extends \common\models\base\modelBase
{
    
     public $dateorTimeFields = [
        'fecha' => self::_FDATETIME, 
       //'fin' => self::_FDATETIME, 
    ];
     
     public $booleanFields=['aprobado'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%turnoscambio}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
             [['fecha','codmotivo','ingreso','descripcion'], 'required'],
            [['turnosasignaciones_id', 'ingreso'], 'integer'],
            [['detalles'], 'string'],
            [['fecha_ingreso_prog','fecha'], 'validate_fechas'],   
             [['ingreso'], 'validate_movimientos'],   
             [['fecha_ingreso_prog','aprobado'], 'safe'],            
            [['descripcion'], 'string', 'max' => 40],
            [['codocuref', 'codmotivo'], 'string', 'max' => 3],
            [['numdocuref'], 'string', 'max' => 20],
            [['fecha'], 'string', 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'turnosasignaciones_id' => Yii::t('app', 'Turnosasignaciones ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalles' => Yii::t('app', 'Detalles'),
            'ingreso' => Yii::t('app', 'Ingreso'),
            'codocuref' => Yii::t('app', 'Codocuref'),
            'numdocuref' => Yii::t('app', 'Numdocuref'),
            'codmotivo' => Yii::t('app', 'Codmotivo'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TurnoscambioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TurnoscambioQuery(get_called_class());
    }
    
    
    public function getTurnoasignado(){
        
        return $this->hasOne(Turnosasignaciones::className(), ['id' => 'turnosasignaciones_id']);
    
    }
    
    
    
    /*
     * La fecha debe de estar en los rangos del turno
     *
     * Puede ser una fecha pasada 8Regularización)
     * Puede ser una fecha futura (Programada)
     * 
     * 
     * 
     *  $fecha_ingreso_prog debes ser mayor que $fecha si es que existe
     * 
     *  $fecha_ingreso_prog debe de estar en el rango, si es que existe
     *  
     */
    
    
    public function validate_fechas($attribute,$params){
        $fecha=$this->toCarbon('fecha');
        
        if(!$fecha->betweenIncluded($this->turnoasignado->toCarbon('finicio'),$this->turnoasignado->toCarbon('fin'))){
            $this->addError(
                    $attribute,
                    yii::t('base.errors','La fecha debe de estar dentro del rango del turno, revise por favor')
                    );
        }
        
        if(!is_null($this->fecha_ingreso_prog)){
            $prog=$this->toCarbon('fecha_ingreso_prog');
            if(!$prog->betweenIncluded($this->turnoasignado->toCarbon('finicio'),$this->turnoasignado->toCarbon('fin'))){
            $this->addError(
                    $attribute,
                    yii::t('base.errors','La fecha programada debe de estar dentro del rango del turno, revise por favor')
                    );
            
             }
          if($prog->gt($fecha)){
              $this->addError(
                    $attribute,
                    yii::t('base.errors','La fecha programada debe de ser menor que la fecha inicial, revise por favor')
                    );
          }
        }
        
        
    }
    
    /*
     * NO puede haber un movimiento de incoropracion
     * si no ha salido antes
     * 
     * 
     * No puede haber un movimiento de salida
     * si no esta incorporado
     * 
     */
    
    public function validate_movimiento($attribute,$params){
        if(!$this->turnoasignado->hasPermisos()){
           if($this->ingreso > 0 ) {
               $this->addError(
                    $attribute,
                    yii::t('base.errors','El trabajador ya está incorporado, no es posible este cambio')
                    );
            }
        }else{
            $permiso=$this->turnoasignado->lastPermiso();
            if($permiso->ingreso*$this->ingreso >0) //Sin son del mismo signo no puede ser , los movimientos son alternados : salida /imgreso/salida 
            $this->addError(
                    $attribute,
                    yii::t('base.errors','No es posible este movimiento, revise el estado de este trabajador ')
                    );
        }
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert){
            //if($this->ingreso < 0 ){//Si sale tenemos que cambiar el estado al trabajador en el turno
                //$this->refresh();
                //Turnosasignaciones::updateAll(['activo'=>'0'], ['id'=>$this->turnosasignaciones_id]);
            //}
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    
   public function setAprobado($aprobado=true){
       $this->aprobado=$aprobado; return $this;
   }
    
}
