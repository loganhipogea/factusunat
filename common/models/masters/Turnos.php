<?php

namespace common\models\masters;
use common\helpers\timeHelper;
use common\helpers\h;
use Yii;
use frontend\modules\op\models\OpTareo;
/**
 * This is the model class for table "{{%turnos}}".
 *
 * @property int $id
 * @property string|null $codarea_id
 * @property string|null $desturno
 * @property string|null $detalle
 * @property string|null $activo
 */
class Turnos extends \common\models\base\modelBase
{
   
  public $booleanFields=['activo'];
   public $dateorTimeFields = [
        'finicio' => self::_FDATETIME, 
       'fin' => self::_FDATETIME, 
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%turnos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalle'], 'string'],
             [['finicio','fin','codarea_id'], 'required'],
            [['finicio','fin'], 'validate_fechas'],
            [['activo','hsemanal','finicio','fin'], 'safe'],
            [['codarea_id'], 'string', 'max' => 4],
            [['desturno'], 'string', 'max' => 40],
           // [['activo'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codarea_id' => Yii::t('app', 'Codarea ID'),
            'desturno' => Yii::t('app', 'Desturno'),
            'detalle' => Yii::t('app', 'Detalle'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TurnosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TurnosQuery(get_called_class());
    }
    
    private function createDetalles(){
        foreach(timeHelper::daysOfWeek() as $ndia=>$nombre){
            Detturnos::firstOrCreateStatic([
                'dia'=>$ndia,'activo'=>true,
                'turno_id'=>$this->id,
                'hi'=>'08:00',
                'hf'=>'18:00'
                ],
                    null,
                    ['turno_id'=>$this->id,'dia'=>$ndia],
                    false
                    );
        }
    }
    
    public function validate_fechas($attribute,$params){
       // yii::error(var_dump($this->toCarbon('fin')->diffInDays($this->toCarbon('finicio'))+0),__FUNCTION__);
        //yii::error($this->toCarbon('fin')->diffInDays($this->toCarbon('finicio')),__FUNCTION__);
        if( $this->toCarbon('fin')->diffInDays($this->toCarbon('finicio')) < 7 )
         $this->addError($attribute,yii::t('base.errors','Las fechas no son compatibles debe de haber una dierencia de fechas como mínimo una semana'));
    }
    
    public function getDias(){
    
        return $this->hasMany(Detturnos::className(), ['turno_id' => 'id']);
   
    }
    
   public function getAsignados(){
    
        return $this->hasMany(Turnosasignaciones::className(), ['turno_id' => 'id']);
   
    }  
    
    public function setHorasSemana(){
        $this->hsemanal=$this->horasSemana();
        return $this;
    }
    
    
    public function afterSave($insert, $changedAttributes) {
        if($insert){
            $this->refresh();
            $this->createDetalles();
            //$this->hsemanal=$this->horasSemana();
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function horasSemana(){
        return $this->getDias()->andWhere(['activo'=>'1'])->sum('horas');
    }
    
    /*
     * Siempre que la fecha actual esté dentro de los limites definidos 
     * del turno, ya además este activo el status. Cualquier otra
     * psoibilidad el turno se invalida
     */
    public function isVigente(){
       return  $this->CarbonNow()->
               betweenIncluded($this->toCarbon('finicio'),$this->toCarbon('fin')) &&    
               $this->activo  ;
    }
    
   public function isPosibleDesactivar(){
       return true;
   }
   
   
   public function desactiva($activo=true){
       $this->activo=$activo;
       return $this;
   }
   
   public function nAsignados(){
     return $this->getAsignados()->andWhere(['activo'=>'1'])->count();
   }
   
   public function createParte(\Carbon\Carbon $fecha){
       $modelDay=$this->dia($fecha->weekday());
    
       OpTareo::firstOrCreateStatic(
               [
                   'turno_id'=>$this->id,
                   'fecha'=>self::SwichtFormatDate($fecha->format(h::gsetting('timeBD', 'date')),'date',true),
                   'hinicio'=>$modelDay->hi,
                    'hfin'=>$modelDay->hf,
                   'proc_id'=>1,
                   
               ],
               null, 
               [
                   'turno_id'=>$this->id,
                   'fecha'=>$fecha->format(h::gsetting('timeBD', 'date'))]
               );
   }
   /*
    * Devuelv el registro active RECORD Del dia
    */
   public function dia($ndia){
       return $this->getDias()->andWhere(['dia'=>$ndia])->one();
   }
   
    
}
