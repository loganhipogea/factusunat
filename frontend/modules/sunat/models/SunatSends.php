<?php

namespace frontend\modules\sunat\models;
use yii\helpers\Json;
use common\helpers\h;
use common\helpers\FileHelper;
use common\behaviors\FileBehavior;
use Greenter\Model\Response\Error;
use Yii;

/**
 * This is the model class for table "{{%sunat_sends}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $username
 * @property string|null $cuando
 * @property string|null $resultado
 * @property string|null $mensaje
 */
class SunatSends extends \common\models\base\modelBase
{
    
    public $booleanFields=['resultado'];
    
     public $dateorTimeFields=[
          'cuando'=>self::_FDATETIME,
          //'fvencimiento'=>self::_FDATE,
    ];
    const ST_SUCCESS='exito';
    const ST_ERROR='error';
    
    const TYPE_SEND_INVOICE='10';
    const TYPE_SEND_VOUCHER='20';
    const TYPE_SEND_SUMMARY='30'; 
    const TYPE_SEND_CREDIT_NOTE='40';
    const TYPE_SEND_DEBIT_NOTE='50';
    const TYPE_SEND_VOID_INVOICE='60';
    const TYPE_SEND_VOID_VOUCHER='70';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sunat_sends}}';
    }
    public function behaviors() {
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
            [['user_id'], 'integer'],
            [['caja_id','ndia','numero','ticket','tipo'], 'safe'],
            //[['mensaje'], 'string'],
            [['username'], 'string', 'max' => 255],
            [['cuando',], 'string', 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'user_id' => Yii::t('base.names', 'User ID'),
            'username' => Yii::t('base.names', 'Username'),
            'cuando' => Yii::t('base.names', 'Cuando'),
            'resultado' => Yii::t('base.names', 'Resultado'),
            'mensaje' => Yii::t('base.names', 'Mensaje'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SunatSendsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SunatSendsQuery(get_called_class());
    }
    
      public function afterFind(){
          //YII::ERROR($this->mensaje,__FUNCTION__);
        $this->mensaje=Json::decode($this->mensaje);
        //YII::ERROR('luefgo de decode',__FUNCTION__);
        //YII::ERROR($this->mensaje,__FUNCTION__);
        //unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
        return parent::afterFind();
    }
    
    public function beforeSave($insert){
        //YII::ERROR($this->mensaje,__FUNCTION__);
        //YII::ERROR($this->mensaje,__FUNCTION__);
        $this->mensaje=Json::encode($this->mensaje);
        $this->cuando=$this->currentDateInFormat(true);
        $this->user_id=h::userId();
       // $this->resultado=
        return parent::beforeSave($insert);
    }
    
    public function setSuccess(){
        $this->resultado=self::ST_SUCCESS;
        return $this;
    }
    public function setError(){
        $this->resultado=self::ST_ERROR;
        return $this;
    }
    
     
 

 
 
 public function urlCdr(){
     $url='';
     if($this->hasAttachments()){
         yii::error('tiene attach');
         foreach($this->files as $file){
             yii::error('recorriendo el for '.$file->type);
           if($file->type=='zip'){
               yii::error('ENCONTRO EL ZIP Y DEVUELVE EL URL '.$file->type); 
               $url=$file->url;break;
           } 
         }
         yii::error('DEVUEVE EL URL HALLADO Y ES '.$url);
      return $url;   
             
     }else{
         yii::error('SEND NO TIENE ADJUNTOS DEVUIELVE BNLACO ');
      return $url;   
     }
 }
 public function urlXml(){
   $url='';
     if($this->hasAttachments()){
         foreach($this->files as $file){
           if($file->type=='xml'){
               $url=$file->url;break;
           } 
         }
      return $url;   
             
     }else{
      return $url;   
     }  
 }   
}
