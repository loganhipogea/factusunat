<?php

namespace frontend\modules\cc\models;
use common\helpers\FileHelper;
use common\behaviors\FileBehavior;
use common\models\masters\Clipro;
use Yii;

/**
 
 */
class CcCompras extends \common\models\base\modelBase
{
    use \frontend\modules\cc\traits\CcTrait;
    
      public $dateorTimeFields = [
        'fecha' => self::_FDATE,
        /*'finicio' => self::_FDATETIME,
        'ftermino' => self::_FDATETIME*/
    ];  
    private $_costo_directo=-1;
    private $_costo_indirecto=-1;
     private $_costo_orden=-1;
     private $_costo_faltante=-1;
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
            [['id', 'mes', 'movimiento_id'], 'integer'],
            [['monto', 'igv', 'monto_usd', 'igv_usd'], 'number'],
            [['codocu', 'prefijo', 'codmon'], 'string', 'max' => 3],
            [['monto'], 'validate_monto'],
            [['activo','detalle','parent_id','acumulado','monto_calificado'], 'safe'],
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
        return new CcComprasQuery(get_called_class());
    }
    public function getCalificaciones()
    {
        return $this->hasMany(CcGastos::className(), ['comprobante_id' => 'id']);
    }
    
     public function getDocumento()
    {
        return $this->hasOne(\common\models\masters\Documentos::className(), ['codocu' => 'codocu']);
    }
    
     public function getPadre()
    {
        if($this->parent_id>0)
        return $this->hasOne(CcRendicion::className(), ['id' => 'parent_id']);
    
        return null;
    }
    
    
    
    public function acumulado($exceptId=null,$express=null){
        if(!is_null($express))
        return $this->monto_calificado;
        if(is_null($exceptId))
        return $this->getCalificaciones()->sum('monto');
        return $this->getCalificaciones()->andWhere(['<>','id',$exceptId])->sum('monto');
    }
    
    
    public function getCostoIndirecto(){
        if($this->_costo_indirecto<0){
            $this->_costo_indirecto=$this->getCalificaciones()
                    ->andWhere(['tipo'=>$this->codigo_costo_indirecto()])
                       ->sum('monto');
        }
       return $this->_costo_indirecto;
    }
     public function getCostoDirecto(){
        if($this->_costo_directo<0){
            $this->_costo_directo=$this->getCalificaciones()
                    ->andWhere(['tipo'=>$this->codigo_costo_directo()])
                       ->sum('monto');
           /* echo $this->getCalificaciones()
                    ->andWhere(['tipo'=>$this->codigo_costo_directo()])->
                    createCommand()->rawSql; die();*/
        }
       return $this->_costo_directo;
    }
    
    public function getCostoOrden(){
        if($this->_costo_orden<0){
            $this->_costo_orden=$this->getCalificaciones()
                    ->andWhere(['tipo'=>$this->codigo_costo_orden()])
                       ->sum('monto');
        }
       return $this->_costo_orden;
    }
    
    public function getCostoSinCalificar(){
        if($this->_costo_faltante<0){
           $this->_costo_faltante=$this->monto-(
                   $this->costoDirecto+$this->costoIndirecto+$this->costoOrden);
        }
       return $this->_costo_faltante;
    } 
    
    public function PorcentajeAvanceCalificacion($express=null){
      if($this->monto >0){
          return  100*round($this->acumulado(null,$express)/$this->monto,3);
      }else{
          return 0;
      }
        
    }
    
    
    /*
     * Array para graficos
     */
    
    public function ArrayCostosPorTipo(){
      return [
           self::codigo_costo_directo()=>$this->costoDirecto,
           self::codigo_costo_indirecto()=>$this->costoIndirecto,
           self::codigo_costo_orden()=>$this->costoOrden,
           self::codigo_costo_sin_calificar()=>$this->costoSinCalificar,
      ];  
    }
    
    public function ArrayPorcCostosPorTipo(){
      return [
           self::codigo_costo_directo()=>round(100*$this->costoDirecto/$this->monto,1),
           self::codigo_costo_indirecto()=>round(100*$this->costoIndirecto/$this->monto,1),
           self::codigo_costo_orden()=>round(100*$this->costoOrden/$this->monto,1),
           self::codigo_costo_sin_calificar()=>round(100*$this->costoSinCalificar/$this->monto,1),
      ];  
    }
    
    
    public function despro(){
      if(is_null($model=Clipro::findOne(['rucpro'=>$this->rucpro]))){
         return ''; 
      }else{
         return $model->despro; 
      }
    }
    
    public function beforeSave($insert) {
        if($insert) $this->activo=true;
        return parent::beforeSave($insert);
    }
    
    public function validate_monto($attribute,$params){
       /*
    * Primero verificar si es un hijo de un fondo
    * fijo
    */ 
       
       
       if($this->hasChanged('monto')){
           if($this->isChild() && $this->padre->completo())
           $this->adderror('monto',Yii::t('app', 'El monto de este comprobante no es modificable, el fondo ya está rendido'));
           if($this->acumulado() >0)
            $this->adderror('monto',Yii::t('app', 'El monto de este comprobante no es modificable, tiene calificaciones. Primero elimine las califiaciones'));
           
       }
   }
   
   public function isChild(){
       return $this->parent_id>0;
   }
}
