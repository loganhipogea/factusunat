<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
use frontend\modules\mat\models\MatKardex;
use frontend\modules\mat\models\MatAtenciones;
USE frontend\modules\mat\interfaces\ReqInterface;
use frontend\modules\mat\interfaces\EstadoInterface;
use common\models\masters\Transacciones;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%mat_detvale}}".
 *
 * @property int $id
 * @property int $vale_id
 * @property string $item
 * @property string $cant
 * @property string $um
 * @property string $codart
 * @property string $codest
 *
 * @property Maestrocompo $codart0
 */
class MatDetvale extends \common\models\base\modelBase 
implements ReqInterface,EstadoInterface {

        const ESTADO_CREADO='10';
        const ESTADO_APROBADO='20';
        const ESTADO_ANULADO='99';
        CONST MOV_SALIDA='scenario_i';
        CONSt MOV_INGRESO='scenario_i';

   private $_cantreal=null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detvale}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vale_id', 'codart','cant','punit','um'], 'required'],
            [['vale_id'], 'integer'],
            [['detreq_id'], 'required','on'=>self::MOV_SALIDA],
            [['cant'], 'number'],
            [['cant'], 'validate_cant_stock'],
            [['um'], 'verify_um'],
           // [['codart'], 'validate_stock'],
             [['valor','cant','punit','codal'], 'safe'],
            [['item', 'um'], 'string', 'max' => 4], 
            [['codart'], 'string', 'max' => 14],
            [['codest'], 'string', 'max' => 2],
           // [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
        ];
    }

    
    public function scenarios() {
            $scenarios = parent::scenarios();
            $scenarios[self::MOV_SALIDA] = [ 'vale_id', 'codart', 'cant', 'valor', 'item', 'um','descripcion'];
            $scenarios[self::MOV_INGRESO] = [ 'vale_id', 'codart', 'cant', 'valor', 'item', 'um','descripcion','detreq_id'];
        
            return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vale_id' => Yii::t('app', 'Vale ID'),
            'item' => Yii::t('app', 'Item'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'codart' => Yii::t('app', 'Codart'),
            'codest' => Yii::t('app', 'Codest'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }
    
   
    
     public function getKardex()
    {
        return $this->hasOne(MatKardex::className(), ['vale_id' => 'id']);
    }
    
     public function getVale()
    {
        return $this->hasOne(MatVale::className(), ['id' => 'vale_id']);
    }

     public function stock()
    {
         //yii::error(MatStock::find()->where(['codart'=>$this->codart,'codal'=>$this->codal])->createCommand()->rawSql);
        return MatStock::find()->where(['codart'=>$this->codart,'codal'=>$this->codal])->one();
    }
        public function getAtenciones()
    {
        return $this->hasMany(MatAtenciones::className(), ['detvale_id' => 'id']);
    }
    
     
    
    
    
    public function cant_atendida(){
       return $this->atenciones()->sum('cantidad');
    }
    /**
     * {@inheritdoc}
     * @return MatDetvaleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetvaleQuery(get_called_class());
    }
    
     public function beforeSave($insert) {
        if($insert){
            
           // $this->activo=true;            
            $this->item='1'.str_pad($this->vale->getDetalles()->count()+1,3,'0',STR_PAD_LEFT);
            $this->codest=self::ESTADO_CREADO;
        }
        yii::error('Otra ve el precio unitaro',__FUNCTION__);            
          yii::error($this->punit,__FUNCTION__);
        $signo=$this->vale->transaccion->signo;
        $this->valor=$this->punit*$this->cant*$signo;
        yii::error('El valor ',__FUNCTION__);            
          yii::error($this->valor,__FUNCTION__);
        
        return parent::beforeSave($insert);
    }
    
    public function getCantReal(){
        if(is_null($this->_cantreal) && !$this->isNewRecord){
          $this->cant=$this->cant*$this->material->factorConversion($this->um);
        }
        return $this;       
    }
    
    
    
   
  public function verify_um() {
    if(!empty($this->codart)){
       $material=$this->material;
     if($this->um <> $material->codum && !$material->existsUm($this->um,false)){
          $this->addError('um',yii::t('base.errors','Este material no tiene registrada esta unidad de medida'));
       }  
    }
     
  }
  
  
  private function createKardex($idstock){
      $kardex=new MatKardex();
      $vale=$this->vale;
      $signo=$vale->transaccion->signo;
      $kardex->setAttributes([
          'stock_id'=>$idstock,
          'signo'=>$signo,
           'codart'=>$this->codart,
          'cant'=>$this->cant*$signo,
          'um'=>$this->material->codum,
          'umreal'=>$this->um,
          'fecha'=>$vale->fecha,
          'codal'=>$this->codal,
          'detvale_id'=>$this->id,
           'codmov'=>$vale->codmov,
          'valor'=>$this->valor,
         // 'detvale_id'=>$this->id,
          //'detreq_id'=>$this->id,
      ]);
     // print_r($kardex->attributes);die();
       $salio=$kardex->save();
       if(!$salio){
                   $key=$vale->id.'sesion'.h::userId();
                  $sesion=h::session();
                  $errores=$sesion->get($key);
                  $errores['Kardex']=$kardex->getFirstError();
                  $sesion->set($key,$errores);
       }
      //print_r($kardex->getErrors());
     return $salio;
     //return $kardex->save();
  }
  
  private function createStock(){
      $stock= New MatStock();
     // $vale=$this->vale;
      $stock->setAttributes([
          'codart'=>$this->codart,
          'cant'=>$this->cant,
          'cantres'=>0,
          'cant_disp'=>0,
          'codal'=>$this->codal,
          //'signo'=>$vale->signo(),
          //'cant'=>$this->cant,
          'um'=>$this->material->codum,
          'valor'=>$this->valor,
          
      ]);
      $salio=$stock->save();
      
      //print_r($stock->getErrors());
     return $salio;
  }
  
  
  /*Verifica que haya registro de stock
   * si no bora error
   * 
   */
  /*public function validate_stock(){
     if(is_null($this->stock))
     $this->addError ('codart',yii::t('base.errores','No existe registro de stock para este material'));
  }*/
  
  private function updateStock(MatStock $stock){
      /*
       * Actualizando las cantidades primero
       */   
      
      $vale=$this->vale;
      $transaccion=$vale->transaccion;
      
       $signo=$transaccion->signo;
      $cantidad=$this->cantreal->cant*$signo;      
      $afecta_reserva=$transaccion->afecta_reserva;      
       $afecta_precio=$transaccion->afecta_precio;       
       
       if(!$transaccion->es_servicio){
       
       if($stock->isNewRecord){
          $stock->setAttributes([
          'codart'=>$this->codart,
          'cant'=>$this->cant,
          'cantres'=>0,
          'cant_disp'=>0,
          'codal'=>$this->codal,
          'um'=>$this->material->codum,
                    ]); 
             }       
      /*
       * Si se trata de movimientos que afectan la reserva
       * 
       */
      if($afecta_reserva){
          $stock->cantres+=$cantidad;          
      }else{
         $stock->cant_disp+=$cantidad;   
      }
      
       /*
       * Si se trata de movimientos que afectan el precio
       * 
       */
      if($afecta_precio){ //Sacamos el P.U. del mismo vale
          $montoafectado=abs($this->punit)*abs($this->cant)*$signo;           
      }else{//Sacamos el P.U. del stock o del vale dependiendo
          
            $montoafectado=abs($stock->valor_unit)*abs($this->cant)*$signo;  
          
          
         
         
         
      }
      $stock->valor=(is_null($stock->valor)?0:$stock->valor)+$montoafectado;
        
            /*
             * Aquí el stock solito se las arregla en el resolveStock
             */
              $exito=$stock->save();
              //yii::error('Los errores',__FUNCTION__);
              //yii::error($stock->getErrors(),__FUNCTION__);
              $stock->refresh();
              if(!$exito){ 
                  $key=$vale->id.'sesion'.h::userId();
                  $sesion=h::session();
                  $errores=$sesion->get($key);
                  $errores['Stock']=$stock->getFirstError();
                  $sesion->set($key,$errores);
                  return false;
                  
                  
              }
              return $stock->id;
       }
  }
 
/*Establece la trazabilidad de 
 * de la compra
 */
  private function trazabilidad(){
     if($this->detreq_id>0){
          $atenciones= (MatAtenciones::instance());
        $atenciones->setAttributes([
          'detreq_id'=>$this->detreq_id,
          'detvale_id'=>$this->id,
            'cant'=>$this->cant,
      ]);
         $salio=$atenciones->save();
      //print_r($atenciones->getErrors());
     return $salio;
        //return $atenciones->save();
     }else{
         return false;
     }
     
  }
  
  
  /*
   * Ejecuta todas las acciones cuando se 
   * aprueba el item
   */
  public function aprobado(){
    
       //$this->trazabilidad();
         $this->codest=self::ESTADO_APROBADO;
          $vale=$this->vale;
         $stock=$this->stock();
           /*
           * Actualizamos el P.U. pero de este vale
           * ¿Por que?:  Porque de este modo nos aseguramos que 
           * quede una foto del precio verdaero con el que se ha movido
           * en el vale
           */
          if(!is_null($stock) && !$this->vale->transaccion->afecta_precio){
              $this->punit=$stock->valor_unit;
          }
         $exito=$this->save();
         if(!$exito){
             yii::error('Se esta guardando el error en la clave',__FUNCTION__);
             yii::error($vale->id.'sesion'.h::userId(),__FUNCTION__);
             yii::error($this->getFirstError(),__FUNCTION__);
                  $key=$vale->id.'sesion'.h::userId();
                  $sesion=h::session();
                  $errores=$sesion->get($key);
                  $errores['Item']=$this->codart.'-'.$this->getFirstError();
                  $sesion->set($key,$errores); 
            return $exito;
         }
      
      
      
      $vale=$this->vale;
    ///  $transaccion=$this->getDb()->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
        if(is_null($stock)){
            $idStock=$this->updateStock(New MatStock());
        }else{
            $idStock=$this->updateStock($stock);
        }
        
       // yii::error($idStock,__FUNCTION__);
        //yii::error('Entrando al create kardex',__FUNCTION__);
           if(!$idStock) return $idStock;
           $exito=$this->createKardex($idStock);  
           if(!$exito)return $exito;
        
         
        return $exito;
      //$transaccion->commit();
      
   }
   
   public function validate_cant_stock(){
       /*
        * Siempre que se intente sacar algo
        * verificar primero si las cantidades son
        * consistentes
        */
       if($this->vale_id >0){
           $transaccion=$this->vale->transaccion;
       }else{
          $envioPost=h::request()->post(); 
          $transaccion= Transacciones::findOne(['codtrans'=>$envioPost['MatVale']['codmov']]);
       }
       
      // var_dump($this->stock(),$this->attributes ,$transaccion);die();
      if($transaccion->signo <0){
           if(is_null($stock=$this->stock())){
              $this->addError('codart',yii::t('base.errors','El material no tiene registro de stock'));
          }else{
              //yii::error('Los atributos del stock',__FUNCTION__);
              //yii::error($stock->attributes,__FUNCTION__);
             if($transaccion->afecta_reserva){
                if($this->getCantReal()->cant > $stock->cantres){
                $this->addError('cant',yii::t('base.errors','No hay cantidad suficiente {canti} de material reservado en stock',['canti'=>$stock->cant_disp]));  
                }  
             }else{
                if($this->getCantReal()->cant > $stock->cant_disp){
                $this->addError('cant',yii::t('base.errors','No hay cantidad suficiente {canti} de material en stock',['canti'=>$stock->cant_disp]));  
                }   
             }
              
          }
      }else{//Que sucede sin son positivo pero exige historial
          if($transaccion->exigehistorial){
             if(is_null($stock=$this->stock())){               
             $this->addError('codart',yii::t('base.errors','Este material no tiene registro g de stock {df}',['df'=>$this->codal]));  
               }else{
                   if($stock->valor_unit==0)
                   $this->addError('codart',yii::t('base.errors','Este material no tiene registro x de kardex {df}',['df'=>$this->codal]));  
               
               }
          }
      }
       
   }
     
     public function isCreado(){
        return ($this->codest==self::ESTADO_CREADO)?true:false;
    }
     public function isAprobado(){
       return ($this->codest==self::ESTADO_APROBADO)?true:false; 
    }
     public function isAnulado(){
       return ($this->codest==self::ESTADO_ANULADO)?true:false; 
    }
    public function isBloqueado(){
       return $this->isAnulado()|| $this->isAprobado();
    }
  
   
    
    
}
