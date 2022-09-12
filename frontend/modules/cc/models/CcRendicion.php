<?php

namespace frontend\modules\cc\models;
use common\helpers\FileHelper;
use common\behaviors\FileBehavior;
use common\models\masters\Clipro;
use common\models\masters\Centros;
use common\models\masters\Trabajadores;
use Yii;

/**
 
 */
class CcRendicion extends \common\models\base\BaseDocument
{
    use \frontend\modules\cc\traits\CcTrait;
    public $prefijo='78';
      public $dateorTimeFields = [
        'fecha' => self::_FDATE,
          'fvencimiento' => self::_FDATE,       
          ];  
      
   
    public static function tableName()
    {
        return '{{%cc_rendicion}}';
    }
    
     public function behaviors() {
        return [
            
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
            
        ];
    }
    
    
   
    public function rules()
    {
        return [
             [['movimiento_id'], 'integer'],
           [['monto', 'monto_rendido'], 'number'],
             [['monto'], 'validate_monto'],
           [['detalle'], 'string'],
           [['codcen'], 'string', 'max' => 5],
           [['codsoc'], 'string', 'max' => 1],
           [['numero', 'fecha', 'fvencimiento'], 'string', 'max' => 10],
           [['codmon'], 'string', 'max' => 4],
           [['codtra'], 'string', 'max' => 6],
           [['estado', 'tipopago'], 'string', 'max' => 2],
           [['descripcion'], 'string', 'max' => 40],
           [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
           [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
           [['movimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => CcMovimientos::className(), 'targetAttribute' => ['movimiento_id' => 'id']],
       ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
          
           'id' => Yii::t('app', 'ID'),
           'movimiento_id' => Yii::t('app', 'Movimiento ID'),
           'codcen' => Yii::t('app', 'Codcen'),
           'codsoc' => Yii::t('app', 'Codsoc'),
           'numero' => Yii::t('app', 'Numero'),
           'fecha' => Yii::t('app', 'Fecha'),
           'fvencimiento' => Yii::t('app', 'Fvencimiento'),
           'codmon' => Yii::t('app', 'Codmon'),
           'monto' => Yii::t('app', 'Monto'),
          'monto_rendido' => Yii::t('app', 'Monto Rendido'),
           'codtra' => Yii::t('app', 'Codtra'),
           'estado' => Yii::t('app', 'Estado'),
           'descripcion' => Yii::t('app', 'Descripcion'),
           'detalle' => Yii::t('app', 'Detalle'),
       ];
    }

    /**
     * {@inheritdoc}
     * @return CcComprasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CcRendicionQuery(get_called_class());
    }
   public function getRendiciones()
    {
        return $this->hasMany(CcCompras::className(), ['parent_id' => 'id']);
    }
    
    public function getTrabajador()
    {
        return $this->hasOne(\common\models\masters\Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    public function getMovimiento()
    {
        return $this->hasOne(CcMovimientos::className(), ['id' => 'movimiento_id']);
    }
   
    
    /*
     * Actualzia su monto segun lo rendido 
     * Comprobantes hijos
     */
    public function SincronizaMonto(){
        $this->monto=$this->acumulado();
        return $this->save();
    }
    
    public function beforeSave($insert) {
        if($insert){
           $this->numero=$this->correlativo('numero');
           $this->codsoc= \common\models\masters\VwSociedades::codsoc();
        }
         
        return parent::beforeSave($insert);
    }
    
    /*
     * Consultau obtiene la ultima rendicion de 
     * la serie oo FONDO FIJO
     */
    public function Previous(){
      RETURN  $this->find()->
         andWhere([
                 'codcen'=>$this->codcen, 
                 'codtra'=>$this->codtra, 
                 ])->
         orderBy(['numero'=>SORT_DESC])->one();
    }
    
    
     /*
     * Consultau obtiene la  siguiente rendicion de 
     * la serie oo FONDO FIJO
     */
    public function Next(){
      RETURN  $this->find()->
         andWhere([
                 'codcen'=>$this->codcen, 
                 'codtra'=>$this->codtra, 
                 ])->
         orderBy(['numero'=>SORT_ASC])->one();
    }
    
    
    public function CreaDocCompensacion(){
        if(!($this->HasDocCompensacion())){
            $model=New CcCompras();
            $model->setAttributes([
           'codocu'=>$this->codocu_compensacion,
           //'prefijo'=>$this->codocu_compensacion,
           //'numero'=>$this->codocu_compesacion_hereda,
            'fecha'=>self::currentDateInFormat(),
            'parent_id'=>$this->id,
            'monto'=>$this->faltante(),//negativo 
            // 'monto_rendido'=>$this->faltante(),//negativo 
           'descripcion'=>'COMPENSACION POR EXCESO',
            ]); 
           return $model->save();
        }else{
            $this->addError('glosa',yii::t('base.errors','Este documento ya tiene documento de compensación'));
            return false;            
        }
    }
    
    public function HasDocCompensacion(){
        //return !is_null($this->DocCompensacion());
         $doc=$this->DocCompensacion();
        return is_null($doc)?false:$doc;
    }
    
    public function DocCompensacion(){
      return $this->getRendiciones()->
             andWhere(['codocu'=>$this->codocu_compensacion])->one();
    }
    
    /*
     * Si ya tiene un documento heredado
     */
    public function DocCompensacionHeredado(){
       return $this->getRendiciones()->
             andWhere(['codocu'=>$this->codocu_compesacion_hereda])->one();  
    }
    
    public function HasDocCompensacionHeredado(){
        $doc=$this->DocCompensacionHeredado();
        return is_null($doc)?false:$doc;
    }
    /*
     * Se fija si  existe un
     * documento de compensacion para heredarlo
     * aqui y co el codigo que corresponde
     */
    public function HeredaCompensacion(){
        if(!($documento=$this->HasDocCompensacionHeredado())){
           $this->createDocCompensacionHeredado();
        }
    } 
    
   private function createDocCompensacionHeredado(){
       if(!is_null($modelPrevious=$this->Previous())){
         if($docant=$modelPrevious->HasDocCompensacion()){
            $model=New CcCompras();
            $model->setAttributes([
           'codocu'=>$this->codocu_compesacion_hereda,
           'prefijo'=>$this->codocu_compesacion_hereda,
           //'numero'=>$this->codocu_compesacion_hereda,
            'fecha'=>self::currentDateInFormat(),
            'parent_id'=>$this->id,
            'monto'=>$docant->monto*-1,
            'monto_calificado'=>$docant->monto*-1,
           'glosa'=>'COMPENSACION FONDO ANT.',
            ]); 
           return $model->save();
         }else{
             $this->addError('',yii::t('base.errors','No se encontró documento de compensacion en rendición anterior'));
           
             return false;
         }
         
       }else{
           $this->addError('',yii::t('base.errors','No se encontró  rendición anterior'));
           
           return false;
       }
   }
    public function acumulado($exceptId=null){
        if(is_null($exceptId))
        return $this->getRendiciones()->andWhere(['activo'=>'1'])->sum('monto')+0;
        return $this->getRendiciones()->andWhere(['activo'=>'1'])->
                andWhere(['<>','id',$exceptId])->sum('monto');
    }
    
    public function faltante($exceptId=null){
       return  $this->monto-$this->acumulado($exceptId);
    }
    
   public function porcentajeAvance(){
       $acumulado=$this->acumulado();
     /* var_dump(
               $this->getRendiciones()->andWhere(['activo'=>'1'])->createCommand()->rawSql,
               $acumulado,$this->monto,100*round($acumulado/$this->monto,4));DIE();
       */if($this->monto>0 ){
          
           return 100*round($acumulado/$this->monto,4);
       }else{
           return 0;
       }
           
   }
   
   public function completo(){
     if(!empty($this->monto)){
         yii::error($this->monto,__FUNCTION__);
         yii::error($this->acumulado(),__FUNCTION__);
         return $this->monto==$this->acumulado(); 
         
     }
        
      
      return false;
   }
   
   
   
   
   public function RevierteCompensacion(){
       $model=$this->HasDocCompensacion();
       if($model) return $model->delete();
       return false;
   }
   
   public function AcumuladoCalificacion($exceptId=null){       
        if(is_null($exceptId))
        return $this->getRendiciones()->andWhere(['activo'=>'1'])->sum('monto_calificado')+0;
        return $this->getRendiciones()->andWhere(['activo'=>'1'])->
                andWhere(['<>','id',$exceptId])->sum('monto_calificado');    
   }  
   
   public function porcentajeAvanceCalificacion(){
       $acumulado=$this->AcumuladoCalificacion();
       
       if($this->monto>0 ){
           //var_dump($acumulado,$this->monto);
           return 100*round($acumulado/$this->monto,4);
       }else{
           return 0;
       }
           
   }
   
   public function validate_monto($attribute,$params){       
      $mov=$this->movimiento;
      if($this->isNewRecord){
         $acumulado= $mov->acumulado()+$this->monto;
         //var_dump($mov->acumuladoParaRendir(),$this->monto_a_rendir,$acumulado,$mov->monto);die();
      }else{
         $acumulado=$mov->acumulado($this->id)+$this->monto;
      }
      if($acumulado > $mov->monto){
          $this->addError('monto',yii::t('base.errors','La suma acumulada {acumulado} excede al monto original {monto}',['acumulado'=>$acumulado,'monto'=>$mov->monto]));
      } 
   }
  
   public function areChildsAprobed(){
       RETURN  $this->getRendiciones()->count()==
           $this->getRendiciones()->andWhere(['estado'=>self::ST_PASSED])->count();
  }
 
  public function aprobe(){
      if($this->areChildsAprobed()){
         return $this->setPassed()->save();          
      }
      RETURN FALSE;
  }
  
 /*
  * Ubica el primer comprobante, ordenado por fecha
  * de emision
  */ 
 public function firstComprobante(){
     yii::error($this->getRendiciones()->
             andWhere(['activo'=>'1'])
             ->orderBy(['fecha'=>SORT_ASC,'id'=>SORT_ASC])->createCommand()->rawSql,__FUNCTION__);
     RETURN $this->getRendiciones()->
             andWhere(['activo'=>'1'])
             ->orderBy(['fecha'=>SORT_ASC,'id'=>SORT_ASC])->one();
 }
 
 
  /*
  * Ubica el último comprobante, ordenado por fecha
  * de emision
  */ 
 public function lastComprobante(){
    yii::error( $this->getRendiciones()->
             andWhere(['activo'=>'1'])
           ->orderBy(['fecha'=>SORT_DESC,'id'=>SORT_DESC])->createCommand()->rawSql,__FUNCTION__);
   RETURN $this->getRendiciones()->
             andWhere(['activo'=>'1'])
           ->orderBy(['fecha'=>SORT_DESC,'id'=>SORT_DESC])->one();  
 }
 
 
}
