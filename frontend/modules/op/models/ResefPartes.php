<?php

namespace frontend\modules\op\models;
use common\helpers\timeHelper;
use common\models\masters\Trabajadores;

use Yii;

/**
 * This is the model class for table "resef_parte".
 *
 * @property int $id
 * @property string|null $codtra
 * @property string|null $fecha
 * @property string|null $detalle
 */
class ResefPartes extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
	 
	  public $dateorTimeFields = [
        'fecha' => self::_FDATE,
        
        //'ftermino' => self::_FDATETIME
    ];
     
    public static function tableName()
    {
        return 'resef_parte';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detalle'], 'string'],
            [['codtra'], 'string', 'max' => 6],
            [['fecha'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codtra' => Yii::t('app', 'Codtra'),
            'fecha' => Yii::t('app', 'Fecha'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    public function getDetalles()
    {
        return $this->hasMany(ResefParteDet::className(), ['parte_id' => 'id']);
    }

    
    /**
     * {@inheritdoc}
     * @return ResefPartesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResefPartesQuery(get_called_class());
    }
	
	public static function creaParteDay($codtra,$fecha){
		return self::firstOrCreateStatic(
                [
				'codtra'=>$codtra,
				'fecha'=>self::SwichtFormatDate ($fecha,self::_FDATE,true)
				],
                null,
               [
				'codtra'=>$codtra,
				'fecha'=>$fecha
				],
                false
                );
		
	}
	
	public static function createParteMes($codtra,$mes=null,$anio=null){
	$mes=(is_null($mes))?date("n"):$mes;
         $anio=(is_null($anio))?date("Y"):$anio;   
            
	  $fechas=timeHelper::fechasEnEsteMes(date("n"),date("Y"));
	  foreach( $fechas as $fecha){
		  self::creaParteDay($codtra,$fecha);
	  }
	  
	  
	  
	}
	
	public function nextParte($codtra){
	   $idNext= self::find()->select('min(id)')->
                   andWhere(['>','fecha',$this->swichtDate('fecha', false)])->scalar();
           if($idNext >0){
               
           }ELSE{
               
           }
           return $idNext;
           
           
	  }
          
          
          public function previousParte($codtra){
	   $idPrev= self::find()->select('max(id)')->
                   andWhere(['<','fecha',$this->swichtDate('fecha', false)])->scalar();
           if($idNext >0){
               
           }ELSE{
               
           }
           
          return $idPrev; 
           
	  }
	  
	public function isLastOfMonth(){
           return $this->toCarbon('fecha')->endOFMonth()->format('Y-m-d') ==$this->swichtDate('fecha', false);
        }
	public function isFirstOfMonth(){
           return $this->toCarbon('fecha')->startOFMonth()->format('Y-m-d') ==$this->swichtDate('fecha', false);
        } 
        
        
        
        public function fillActividades(){
          for ($i = 1; $i <= 3; $i++) {
        $model=new  ResefParteDet();
        $model->setAttributes([
            'parte_id'=>$this->id,
            'hinicio'=>'08:30',
            'hfin'=>'10:30',
            'actividad'=>'Actividad'
            ]);
       $model->save();
       
        unset($model);
            }
        
    }
	
}
