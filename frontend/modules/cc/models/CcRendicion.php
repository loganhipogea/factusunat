<?php

namespace frontend\modules\cc\models;
use common\helpers\FileHelper;
use common\behaviors\FileBehavior;
use common\models\masters\Clipro;
use Yii;

/**
 
 */
class CcRendicion extends \common\models\base\modelBase
{
    use \frontend\modules\cc\traits\CcTrait;
    public $prefijo='78';
      public $dateorTimeFields = [
        'fecha' => self::_FDATE,
        /*'finicio' => self::_FDATETIME,
        'ftermino' => self::_FDATETIME*/
    ];  
      
   // const CODIGO_DOC_COMPENSACION='101';
    // const CODIGO_DOC_COMPENSACION_HEREDADO='102';
    /*private $_costo_directo=-1;
    private $_costo_indirecto=-1;
     private $_costo_orden=-1;
     private $_costo_faltante=-1;*/
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cc_compras}}';
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
    
    
    public $booleanFields=['activo'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['codocu','codtra','fecha','glosa','monto_a_rendir'], 'required'],
             [['frecuencia','parent_id','codtra','monto_rendido'], 'safe'],
            
            [['id', 'mes', 'movimiento_id'], 'integer'],
            [['monto', 'igv', 'monto_usd', 'igv_usd'], 'number'],
            [['codocu', 'prefijo', 'codmon'], 'string', 'max' => 3],
            [['activo','detalle',], 'safe'],
            [['numero'], 'string', 'max' => 12],
            [['fecha'], 'string', 'max' => 10],
            [['anio'], 'string', 'max' => 4],
            [['glosa'], 'string', 'max' => 50],
            [['codpro'], 'string', 'max' => 6],
            [['rucpro'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codocu' => Yii::t('app', 'Codocu'),
            'prefijo' => Yii::t('app', 'Prefijo'),
            'numero' => Yii::t('app', 'Numero'),
            'fecha' => Yii::t('app', 'Fecha'),
            'mes' => Yii::t('app', 'Mes'),
            'anio' => Yii::t('app', 'Anio'),
            'glosa' => Yii::t('app', 'Glosa'),
            'codmon' => Yii::t('app', 'Codmon'),
            'monto' => Yii::t('app', 'Monto'),
            'igv' => Yii::t('app', 'Igv'),
            'movimiento_id' => Yii::t('app', 'Movimiento ID'),
            'codpro' => Yii::t('app', 'Codpro'),
            'rucpro' => Yii::t('app', 'Rucpro'),
            'monto_usd' => Yii::t('app', 'Monto Usd'),
            'igv_usd' => Yii::t('app', 'Igv Usd'),
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
        return $this->hasMany(\common\models\masters\Trabajadores::className(), ['codigotra' => 'codtra']);
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
           $this->codocu=$this->codocu_fondo_fijo;
        }
         
        return parent::beforeSave($insert);
    }
    
    /*
     * Consultau obtiene la ultima rendicion de 
     * la serie oo FONDO FIJO
     */
    public function Previous(){
      RETURN  $this->find()->
         andWhere(['prefijo'=>$this->prefijo,'codocu'=>$this->codocu])->
         orderBy(['numero'=>SORT_DESC])->one();
    }
    
    
     /*
     * Consultau obtiene la  siguiente rendicion de 
     * la serie oo FONDO FIJO
     */
    public function Next(){
      RETURN  $this->find()->
         andWhere(['prefijo'=>$this->prefijo,'codocu'=>$this->codocu])->
         orderBy(['numero'=>SORT_ASC])->one();
    }
    
    
    public function CreaDocCompensacion(){
        if(!($this->HasDocCompensacion())){
            $model=New CcCompras();
            $model->setAttributes([
           'codocu'=>$this->codocu_compensacion,
           'prefijo'=>$this->codocu_compensacion,
           //'numero'=>$this->codocu_compesacion_hereda,
            'fecha'=>self::currentDateInFormat(),
            'parent_id'=>$this->id,
            'monto'=>$this->faltante(),//negativo 
                 'monto_calificado'=>$this->faltante(),//negativo 
           'glosa'=>'COMPENSACION POR EXCESO',
            ]); 
           return $model->save();
        }else{
            $this->addError('glosa',yii::t('base.errors'),'Este documento ya tiene documento de compensación');
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
       
       if($this->monto>0 ){
           //var_dump($acumulado,$this->monto);
           return 100*round($acumulado/$this->monto,4);
       }else{
           return 0;
       }
           
   }
   
   public function completo(){      
      return $this->monto==$this->acumulado(); 
   
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
   
}
