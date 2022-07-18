<?php
namespace frontend\modules\sunat\models;
use common\models\masters\VwSociedades;
use Yii;
USE yii\helpers\StringHelper;
use common\helpers\h;
class SunatAccess extends \common\models\base\modelBase
{
    
    public $password1=null;
    private $_keysecret=null;
    private const KEY_WORD='hola';
    public static function tableName()
    {
        return '{{%sunat_access}}';
    }

     public function rules()
    {
        return [
             [['user','password','password1'], 'required'],
            [['password','password1'], 'validatePassword'],
            [['codsoc'], 'string', 'max' => 2],
             [['codsoc'], 'unique'],
            [['user'], 'string', 'max' => 60],
            //[['user'], 'match', 'pattern' => '[A-Z|a-z|0-9._]'],
            [['password'], 'string', 'max' => 300],
            [['path_store_cert'], 'string', 'max' => 400],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'user' => Yii::t('base.names', 'User'),
            'password' => Yii::t('base.names', 'Password'),
            'path_store_cert' => Yii::t('base.names', 'Path Store Cert'),
        ];
    }

     public static function find()
    {
        return new SunatAccessQuery(get_called_class());
    }
    
    public function getSocio(){
        return $this->hasOne(VwSociedades::className(), ['codsoc' => 'codsoc']);
    }
    
    /*
     * SACAMOS LA CLAVE SECRETA Y ES EL RUC
     */
    public function getKeySecret(){
        if(is_null($this->_keysecret)){
            $this->_keysecret=$this->socio->rucpro;
        }
        return $this->_keysecret;
    }
    
    public function validatePassword($attribute,$params){
        if(!($this->password ===$this->password1)){
            $this->addError($attribute,yii::t('base.errors','The passwords don\'t match'));
        }
    }
   
    Private function gPwd(){
       return  Yii::$app->getSecurity()->
                 decryptByKey(StringHelper::base64UrlDecode($this->password), self::KEY_WORD);
    }
    Private function sPwd(){
       return  StringHelper::base64UrlEncode(Yii::$app->getSecurity()->
                encryptByKey($this->password,self::KEY_WORD));
    }
    
    public function beforeSave($insert) {
        $this->password= $this->sPwd() ;
      return parent::beforeSave($insert);
    }
    
    public function afterFind() {
         $this->password= $this->gPwd();
          $this->password1=$this->password;
         parent::afterFind();
    }
    
    /*Extrae el password de autenticacion SUNAT*/
    public static function pwd(){
       if(is_null($credential=self::find()->andWhere(['codsoc'=> VwSociedades::codsoc()])->one())){
          return h::currentController()->redirect(['/sunat/default/create-credentials']);
       }else{
           return $credential->password;
       }
           
    }
    
     public static function usr(){
       if(is_null($credential=self::find()->andWhere(['codsoc'=> VwSociedades::codsoc()])->one())){
          return h::currentController()->redirect(['/sunat/default/create-credentials']);
       }else{
           return $credential->user;
       }
           
    }
}
