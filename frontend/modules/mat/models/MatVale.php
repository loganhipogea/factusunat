<?php

namespace frontend\modules\mat\models;
use common\models\masters\Clipro;
use common\models\masters\Documentos;
use frontend\modules\mat\interfaces\DocRelacionadoValeInterface;
use common\interfaces\DocumentoInterface;
use frontend\modules\mat\models\MatDetvale;
use frontend\modules\mat\behaviors\ReservaBehavior;
use common\interfaces\CosteoInterface;
use common\behaviors\CodocuBehavior;
use yii\base\InvalidConfigException;
use Yii;

/**
 * This is the model class for table "{{%mat_vale}}".
 *
 * @property int $id
 * @property string $numero
 * @property string $fecha
 * @property string $codpro
 * @property string $codmov
 * @property string $descripcion
 * @property string $texto
 * @property string $codest
 *
 * @property Clipro $codpro0
 */
class MatVale extends \common\models\base\modelBase 
implements \frontend\modules\mat\interfaces\EstadoInterface,
 DocumentoInterface


{
    /**
     * {@inheritdoc}
     */
    const ESTADO_CREADO='10';
     const ESTADO_APROBADO='20';
     const ESTADO_CERRADO='30';
      const ESTADO_ANULADO='99';
    public $prefijo='67';
    public $fecha1;
    public $fechacon1;
     public $dateorTimeFields = [
        'fecha' => self::_FDATE,  
          'fechacon' => self::_FDATE,
         'fecha1' => self::_FDATE,  
          'fechacon1' => self::_FDATE,
    ];
    public static function movimientos(){
        return [    
            '100'=>['SALIDA PARA CONSUMO',-1],
            '101'=>['DEVOLUCION',-1],
            '103'=>['ANULACION VALE',-1],
            '900'=>['INGRESO POR COMPRA',1],
             '901'=>['REINGRESO',1],
            ];
        
    }
    
    public function signo(){
       $movimientos= $this->movimientos();
       return $movimientos[$this->codmov][1];
    }
    
    public static function tableName()
    {
        return '{{%mat_vale}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'codpro', 'codmov','codocu','codmon'], 'required'],
            [['texto'], 'string'],
            [['codocu','numerodoc','fechacon'], 'string'],
             [['codocu','numerodoc','fechacon','codal','codcen','codmon','codest'], 'safe'],
            [['numerodoc'], 'validate_docu'],
            [['numero', 'fecha'], 'string', 'max' => 10],
            [['codpro'], 'string', 'max' => 10],
            [['codmov', 'codest'], 'string', 'max' => 3],
            [['descripcion'], 'string', 'max' => 40],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
             [['codocu'], 'exist', 'skipOnError' => true, 'targetClass' => Documentos::className(), 'targetAttribute' => ['codocu' => 'codocu']],
        [['codmov'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\masters\Transacciones::className(), 'targetAttribute' => ['codmov' => 'codtrans']],
        
            ];
    }

    public function behaviors() {
        return [
           
             'ReservaBehavior' => [
                'class' => ReservaBehavior::className(),
                
            ],
            
             'CodocuBehavior' => [
                'class' => CodocuBehavior::className(),
                
            ],
           
        ];
    }
    
    
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Número'),
            'fecha' => Yii::t('app', 'Fecha'),
            'fechacon' => Yii::t('app', 'F Cont'),
            'codpro' => Yii::t('app', 'Proveedor'),
            'codmov' => Yii::t('app', 'Movimiento'),
             'codocu' => Yii::t('app', 'Doc. rel.'),
             'numerodoc' => Yii::t('app', 'Número doc.'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'texto' => Yii::t('app', 'Texto'),
            'codest' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
     public function getDocu()
    {
        return $this->hasOne(Documentos::className(), ['codocu' => 'codocu']);
    }
    
     public function getTransaccion()
    {
        return $this->hasOne(\common\models\masters\Transacciones::className(), ['codtrans' => 'codmov']);
    }
    
  public function getDetalles()
    {
        return $this->hasMany(MatDetvale::className(), ['vale_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     * @return MatValeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatValeQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        IF($insert){
            $this->numero=$this->correlativo('numero',10);
            $this->codest=self::ESTADO_CREADO;
        } 
        
        RETURN parent::beforeSave($insert);
    }
    
    public function Aprobar(){
        
        if($this->isCreado()){
        $transaccion=$this->getDb()->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
      foreach($this->detalles as $detvale){
          //yii::error('recorriendo '.$detvale->codart,__FUNCTION__);
         $exito= $detvale->aprobado();
         if(!$exito){ 
            // yii::error('Hubo un error',__FUNCTION__);
              //yii::error($sesion->get($this->id.'sesion'.\common\helpers\h::userId()),__FUNCTION__);
             //yii::error($detvale->getFirstError(),__FUNCTION__);
              break;}
      }
      
      
      
      
      
        if(!$exito){
            $transaccion->rollBack();
           // return ['error'=>'Ocurrió un error al momento de efectuar la operación'];
        }else{
            $this->codest=self::ESTADO_APROBADO;
            $this->save();
            $transaccion->commit();  
            //return ['success'=>'La operación resultó un éxito'];
        }          
        return $exito;    
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
     public function isCerrado(){
       return ($this->codest==self::ESTADO_CERRADO)?true:false; 
    }
    public function isBloqueado(){
       return $this->isAnulado()|| $this->isAprobado();
    }
    
 public function validate_docu($attribute,$params){
       if($this->transaccion->exigirvalidacion){
           yii::error('si exige validacion',__FUNCTION__);
           $obj=$this->modelTransa();
           if(is_object($obj)){
                yii::error('Encontro el obejto',__FUNCTION__);
                yii::error($obj,__FUNCTION__);
               if($obj instanceof DocRelacionadoValeInterface){
                   yii::error('Si es instancia de interface',__FUNCTION__);
                   $mod=$obj->buscarporNumero($this->numerodoc);
                   yii::error($mod,__FUNCTION__);
                  if($mod===null){
                       yii::error('aGRENAFO EK ELRRO',__FUNCTION__);
                 
                     $this->addError('numerodoc',yii::t('base.errors','No existe el documento con ese número'));
                  }
                   
                     }else{
                  yii::error('NO es instancia de interface',__FUNCTION__);  
               }
           }else{
             yii::error('El objeto e null',__FUNCTION__);  
           }
       }else{
           yii::error('anda',__FUNCTION__);
       }
    }
    
    
    
    /*
     * Funcion que obtiene el modelo del documento relacionado
     * a la transaccion (TABLA TRANSADOCS)
     * 
     */
    private function modelTransa(){
        $model= \frontend\modules\com\models\MatVwTransadocs::findOne([
            'codtrans'=>$this->codmov,
            'codocu'=>$this->codocu,
        ]);
       if(is_null($model)){
           return null;
       }else{
         $objeto=$model->modelo;
         yii::error('el texto del modelo es '.$objeto,__FUNCTION__);
          return $objeto::instance(); 

            }
       }
       
       
      public function ums(){
         
     $query=new \yii\db\Query();
     return $query->select(['um'])->from(MatDetVale::tableName())->distinct()->
      andWhere(['vale_id'=>$this->id])->column();
  
      } 
       
     public function total(){
         return $this->getDetalles()->sum('valor');
     }
     
    
     /*
   * 
   */
  public function ClaseDocRef(){
      
      if(!is_null($reg=Documentos::findOne(['codocu'=>$this->codocu]))){
          $clase=$reg->modelo;
          //yii::error($clase,__FUNCTION__);
          return $clase::findOne([$reg->campofiltro_numero=>$this->numerodoc]);
      }else{
          return null;
      }
      
      
  }
     
 public function isMonedaLocal(){
     return ($this->codmon==\common\models\masters\Tipocambio::COD_MONEDA_BASE);
 }  
 
 public function numero() {
     return $this->numero;
 }
     
       
    }
    
    
      

