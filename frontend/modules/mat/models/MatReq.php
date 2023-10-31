<?php
namespace frontend\modules\mat\models;
use common\models\masters\Trabajadores;
use common\behaviors\CodocuBehavior;
use frontend\modules\mat\behaviors\ReservaBehavior;
use frontend\modules\mat\models\MatReservaDet;
use Yii;
class MatReq extends \common\models\base\modelBase
{
    
    const EST_CRE='100';
    const EST_APRO='101';
    const EST_ANU='999';
    
    public $prefijo='37';
    /**
     * {@inheritdoc}
     */
     public $dateorTimeFields=[
     'fechaprog'=>self::_FDATE,
     'fechasol'=>self::_FDATE,
         
         ];
     
     public $booleanFields=['auto'];
    public static function tableName()
    {
        return '{{%mat_req}}';
    }
    
    
     public function behaviors()
         {
                return [
                     'CodocuBehavior' => [
                        'class' => CodocuBehavior::className(),
                
                        ],
                 'reservaBehavior' => [
                        'class' => ReservaBehavior::className(),
                
                        ], 
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],		
                    ];
        }
    
   
    public function rules()
    {
        return [
          //  [['numero'], 'required'],
            [['texto'], 'string'],
            [['auto'], 'safe'],
            [['numero', 'fechaprog', 'fechasol'], 'string', 'max' => 10],
            [['codtra'], 'string', 'max' => 6],
            [['descripcion'], 'string', 'max' => 40],
            [['codest'], 'string', 'max' => 3],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'fechaprog' => Yii::t('app', 'F. programada'),
            'fechasol' => Yii::t('app', 'F. solicitada'),
            'codtra' => Yii::t('app', 'Solicitante'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'texto' => Yii::t('app', 'Texto'),
            'codest' => Yii::t('app', 'Estado'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getDetalles()
    {
        return $this->hasMany(MatDetreq::className(), ['req_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MatReqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatReqQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
          $this->codest=self::EST_CRE;
          $this->numero=$this->correlativo('numero',10);  
        }
        
        RETURN parent::beforeSave($insert);
    }
    
    public function activate(){
        
        
    }
    
   public function isCreado(){
       return $this->codest==self::EST_CRE;
   }  
   
   public function isAprobado(){
       return $this->codest==self::EST_APRO;
   } 
   
   public function isAnulado(){
       return $this->codest==self::EST_ANU;
   } 
   
   public function isBloqueado(){
       return $this->isAnulado() or $this->isAprobado();
   }
   
   private function setAnulado(){
       $this->codest=self::EST_ANU;       
        return $this;
   }
   
   private function setAprobado(){
       $this->codest=self::EST_APRO;  
       
       return $this;
   }
   
   
   public function aprobar(){
       if($this->isCreado()){
           return $this->setAprobado()->save();           
       }else{
           $this->addError('id',yii::t('base.errors','El estado del documento no permite esta acción'));
           return false;
       }
   }
    
   public function anular(){
       if($this->isCreado()){
           return $this->setAnulado()->save();           
       }else{
           $this->addError('id',yii::t('base.errors','El estado del documento no permite esta acción'));
           return false;
       }
   }
   
   /*Si es un requerimiento 
    * generado automáticamente por
    * una orden
    */
   public function isAuto(){
       return $this->auto;
   }
   
   
   public function idDetalles($codal){
       return $this->getDetalles()->select('id')->andWhere(['codal'=>$codal])->column();
   }
   
   public function idReservas($arrayModels=false,$codal){
       $query=MatReservaDet::find()->select('id')
               ->andWhere(['in','detreq_id',$this->idDetalles($codal)])
               ->andWhere(['in','codestado',MatReservaDet::statusImputables()]);
     
      //echo $query->createCommand()->rawSql;
       if(!$arrayModels)
       return $query->column();
      
       return $query->all();
   }
   
   public function arrayReservas($codal){
    return MatReservaDet::find()->select(['t.detreq_id','t.cant','a.codart','a.um','t.id as detres_id'])
         ->alias('t')->innerJoin(MatDetreq::tableName().' a','t.detreq_id=a.id')
               ->andWhere(['in','t.detreq_id',$this->idDetalles($codal)])
               ->andWhere(['in','t.codestado',MatReservaDet::statusImputables()])
             ->asArray()->all();  
    
    
    
   }
       
}
