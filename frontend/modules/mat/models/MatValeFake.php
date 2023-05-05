<?php
namespace frontend\modules\mat\models;
use yii\base\Model;
use Yii;
use common\helpers\h;
class MatValeFake extends \common\models\base\modelBase
{
   
   public $numerovale=null; 
   public $fecha=null;
   public $codal=null;
    public $dateorTimeFields = [
        'fecha' => self::_FDATE,  
         
    ];
    
    const SCE_ANULACION = 'anular';
    const SCE_TRANSFERENCIA = 'transferir';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'numerovale','fecha'], 'required'],
            [[ 'codal'], 'required','on'=>self::SCE_TRANSFERENCIA],
            [[ 'numerovale'], 'valida_vale'],
            
            ];
    }

    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_ANULACION] = ['numerovale', 'fecha',];
        $scenarios[self::SCE_TRANSFERENCIA] = ['numerovale', 'fecha','codal'];
       
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            
            'numerovale' => Yii::t('app', 'Número'),
            'fecha' => Yii::t('app', 'Fecha'),
           
        ];
    }
    
    public function valida_vale($attribute,$params){
        $vale= MatVale::findOne(['numero'=>$this->numerovale]);
        //var_dump($vale->attributes);die();
        
        if(is_null($vale)){
          $this->adderror('numerovale',yii::t('base.errors','El vale a procesar no existe'));
          return;
        }
        if(!$vale->isAprobado())
        $this->adderror('numerovale',yii::t('base.errors','El vale a procesar no se encuentra en estado aprobado'));
    
        if($this->isScenarioTransferencia()){
                if($vale->codal==$this->codal)
                    $this->adderror('numerovale',yii::t('base.errors','El vale a procesar pertenece a este mismo almacén {codal}',['codal'=>$this->codal]));
             }
       
       // var_dump($vale->transaccion->inversa->attributes);die();
        if($this->isScenarioAnulacion())
        if(is_null($vale->transaccion->inversa))
        $this->adderror('numerovale',yii::t('base.errors','La transacción del vale a anular no tenía inversa'));
        
        /*
         * Que la fecha no sea anterior a la fecha del vale a anular
         */
       if(!is_null($this->fecha))
       if($this->toCarbon('fecha')->lt($vale->toCarbon('fecha')))
         $this->adderror('fecha',yii::t('base.errors','La fecha de anulación debe de ser posterior a la fecha {fecha}',['fecha'=>$vale->fecha]));
         
        
    }
   
    /*
     * Se encarga de crear el vale de 
     * anulación, o transferencia y lo items , por medio 
     * de la referencia del vale a procesar
     */
    public function resolveVale(){
        $valeOriginal=MatVale::findOne(['numero'=>$this->numerovale]);        
        /*
         * Creando la cabecera, todos los datos son iguales excepto 
         * la fecha, el estado y la transacción
         */
        $valeNuevo=New MatVale();
        $valeNuevo->setAttributes($valeOriginal->attributes);
        $valeNuevo->setAttributes([
                    //'codest'=>$valeNuevo::ESTADO_CREADO,
                    'codocu'=> \common\models\masters\Documentos::codigoByModelClass($valeNuevo),
                    'numerodoc'=>$valeOriginal->numero,
                    'fecha'=>$this->fecha,
                    'codmov'=>$valeOriginal->transaccion->inversa->codtrans
                                ]);
        if($this->isScenarioTransferencia()){
           $valeNuevo->codal=$this->codal; 
        }
        $transaccion=$valeNuevo->getDb()->beginTransaction();
            $exito=$valeNuevo->save();
               /*Nos adeguramos que el vale original se usa una sola vez*/
                $valeOriginal->codest=$valeOriginal::ESTADO_CERRADO;
                $exito=$valeOriginal->save();
                if(!$exito){
                    $key='anulacionvale'.h::userId();
                    $sesion=h::session();
                    $errores=$sesion->get($key);
                    $errores['Cabecera']=$valeOriginal->getFirstError();
                    $sesion->set($key,$errores); 
                    return $exito;
                }
                
                
            $valeNuevo->refresh();
            
               foreach($valeOriginal->detalles as $item){
                $modelDetalle=New MatDetvale();
                $atributos=$item->attributes;
                unset($atributos['id']);unset($atributos['punit']);
                $modelDetalle->setAttributes($atributos);
                if($this->isScenarioTransferencia()){
                    $modelDetalle->codal=$this->codal;
                }
                $modelDetalle->vale_id=$valeNuevo->id;
                $stock=$item->stock();
                
                if(!is_null($stock)){$modelDetalle->punit=$stock->valor_unit;};
                
                $exito=$modelDetalle->save();
                 if(!$exito){
                  $key='anulacionvale'.h::userId();
                  $sesion=h::session();
                  $errores=$sesion->get($key);
                  $errores['Item']=$modelDetalle->codart.'-'.$modelDetalle->getFirstError();
                  $sesion->set($key,$errores); 
                    break;
                }
      
              } 
            
            
           if($exito){
               $transaccion->commit();return ['error'=>false,'id'=>$valeNuevo->id];
           }else{
               $transaccion->rollBack();return ['error'=>true,'id'=>$valeNuevo->id];
           }
          
          
    }
    
    public function isScenarioAnulacion(){
        return $this->isScenario(self::SCE_ANULACION);
    }
     public function isScenarioTransferencia(){
        return $this->isScenario(self::SCE_TRANSFERENCIA);
    }
    
    public function setScenarioTransferencia(){
        return $this->setScenario(self::SCE_TRANSFERENCIA);
    }
    public function setScenarioAnulacion(){
        return $this->setScenario(self::SCE_ANULACION);
    }
}

