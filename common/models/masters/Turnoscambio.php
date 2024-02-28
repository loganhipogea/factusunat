<?php

namespace common\models\masters;
use common\behaviors\FileBehavior;
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
    
    public const MOV_INGRESO='300';
    
     public $dateorTimeFields = [
        'fecha' => self::_FDATETIME, 
       'fecha_ingreso_prog' => self::_FDATETIME, 
         'fcierre' => self::_FDATETIME, 
    ];
     
     public $booleanFields=['aprobado','cerrado'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%turnoscambio}}';
    }

    public function behaviors()
{
	return [
		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
               
		
	];
}
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
             [['fecha','descripcion','fecha_ingreso_prog'], 'required'],
             [['fecha'], 'validate_anterior'],
            [['codmotivo'], 'required'],
            [['turnosasignaciones_id', 'ingreso'], 'integer'],
            [['detalles'], 'string'],
            [['fecha_ingreso_prog','fecha','fcierre','cerrado'], 'safe'],   
            [['fecha_ingreso_prog','fecha'], 'validate_fechas'],   
             [['aprobado'], 'validate_estados'],   
             [['fecha_ingreso_prog','aprobado','fcierre'], 'safe'],            
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
    
   private function previousPermiso(){
       if($this->turnoasignado->hasPermisos()){
           $previo=$this->turnoasignado->lastPermiso();
           if($previo->id==$this->id){
               return $this->turnoasignado->getPermisos()
                       ->andWhere(['<','fecha',$this->fecha])
                       ->orderBy(['fecha'=>SORT_DESC])->one();
           }else{
              return $previo;
           }
       }else{
           return null;
       }
          
   }
    
    
     
    /*
     * No puede crear un nuevo archivo 
     * si hay un anterior que no esté cerrado
     */
    public function validate_anterior($attribute,$params){
        if($this->isNewRecord){
            if($this->turnoasignado->hasPermisos()){
                if(!$ultimoDocumento=$this->turnoasignado->lastPermiso()->cerrado)
                    $this->addError(
                               $attribute ,
                                     yii::t('base.errors',
                                             'No puede crear un nuevo documento, existe uno anterior que no está cerrado',
                                         [])
                                    );
            }  
        }
    }
    
    
    
    
    /*
     * No puede pasar a  cerrado si no esta aprobado
     * No puede pasar a cerrado si no hay fecha de cierre
     * No puede pasar a desaprobado si hay fecha de cierre
     * No puede pasar a desaprobado si esta cerrado
     * 
     */
    public function validate_estados($attribute,$params){
        if($this->cerrado && !$this->aprobado){
            $this->addError(
                               $attribute ,
                                     yii::t('base.errors',
                                             'No puede cerrar sin antes aprobar',
                                         [])
                                    );
        }
        if($this->cerrado && empty($this->fcierre)){
            $this->addError(
                               $attribute ,
                                     yii::t('base.errors',
                                             'No puede cerrar sin antes especificar la fecha de cierre',
                                         [])
                                    );
        }
         if(!$this->aprobado && $this->cerrado){
            $this->addError(
                               $attribute ,
                                     yii::t('base.errors',
                                             'No puede desaprobar porque ya está cerrado',
                                         [])
                                    );
        }
        if(!$this->aprobado && !empty($this->fcierre)){
            $this->addError(
                               $attribute ,
                                     yii::t('base.errors',
                                             'No puede desaprobar porque ya hay una fecha de cierre',
                                         [])
                                    );
        }
        
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
     * 
     *  No puede ingresar una fecha anterior al documento inmediato
     * anterior
     *  
     */
    
    
    public function validate_fechas($attribute,$params){
        
         $fecha=$this->toCarbon('fecha');
         $fechat=$this->toCarbon('fecha_ingreso_prog');
         $fechac=$this->toCarbon('fcierre');
         
         
         $mapFechas=[
           'fecha'  => $fecha,
            'fecha_ingreso_prog'=> $fechat,
            'fcierre'=> $fechac
        ];
         $exito=true;
         foreach($mapFechas as $nombrecampo=>$carboncito){
             if(!is_null($carboncito)){             
                        if(!$this->turnoasignado->isInRangeTurno($fecha))
                            $this->addError(
                                $nombrecampo,
                                     yii::t('base.errors','La fecha debe de estar dentro del rango del turno {finicio} - {fin}, revise por favor',['finicio'=>$this->turnoasignado->turno->finicio,'fin'=>$this->turnoasignado->turno->fin])
                                    );break;$exito=false;
                             
                            } 
         
          }
          if(!$exito) return;
          
          /*Fecha de ingreso prog*/  
            if($fechat->lt($fecha)){
                $this->addError(
                    'fecha_ingreso_prog',
                    yii::t('base.errors','La fecha programada de retorno debe ser mayor a la fecha de inicio, revise por favor')
                    );
            }
            
        
          
          
        /*La fecha debe de ser mayor que la fecha de cierre del documento anterior */
        if($this->turnoasignado->hasPermisos()){
                if(!is_null($previo=$this->previousPermiso())){
                          if($fecha->lt($previo->toCarbon('fcierre'))){
                            $this->addError(
                                    'fecha',
                                 yii::t('base.errors','Hay un documento anterior con fecha de cierre mayor a este documento, revise por favor')
                                    ); 
                            }
                }
            
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
    public function beforeSave($insert) {
        if(!empty($this->fcierre)){
            $this->cerrado=true;
        }
        return parent::beforeSave($insert);
    }
    
   public function setAprobado($aprobado=true){
       $this->aprobado=$aprobado; return $this;
   }
   
   
   public function isSalida(){
       return $this->ingreso <0;
   }
   
   
   public function soyElMasReciente(){
       if(!$this->isNewRecord){
           $idMaximo=$this->turnoasignado->lastPermiso()->id;            
            return ($this->id >= $idMaximo);
            
       }else{
           return false;
       }
   }
   
   
   public function setCerrado(){
       
   }
   
   public function lapso(){
       return $this->toCarbon('fecha_ingreso_prog')->locale('es_PE')->diffForHumans($this->toCarbon('fecha'),\Carbon\CarbonInterface::DIFF_RELATIVE_TO_OTHER);
   }
   
   
}
