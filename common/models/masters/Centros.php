<?php

namespace common\models\masters;
use common\models\config\Parametros;
use common\models\base\modelBase;
use common\helpers\h;
use common\models\masters\CentrosParametros;
use common\models\base\modelBaseTrait;
use Yii;

/**
 * This is the model class for table "{{%centros}}".
 *
 * @property string $codcen
 * @property string $nomcen
 * @property string $codsoc
 * @property string $descricen
 *
 * @property Sociedades $codsoc0
 */
class Centros extends modelBase
{
   //use modelBaseTrait;
    /**
     * {@inheritdoc}
     */
    const CURRENT_CENTER_KEY_CACHE='key_center_sesion';
    public static function tableName()
    {
        return '{{%centros}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $reglas= [
            [['codcen', 'nomcen'], 'required'],
             [['codcen', 'nomcen','codpro'], 'safe'],
             [['codcen'], 'match','pattern'=>'/[1-9]{1}[0-9]{1,4}$/'],
            [['descricen'], 'string'],
            [['codcen'], 'string', 'max' => 4],
            [['nomcen'], 'string', 'max' => 60],
             [['codpro'], 'string', 'max' => 10],
           // [['codsoc'], 'string', 'max' => 1],
            [['codcen'], 'unique'],
           //[['codsoc'], 'exist', 'skipOnError' => true, 'targetClass' => Sociedades::className(), 'targetAttribute' => ['codsoc' => 'socio']],
        ];
         return   \yii\helpers\ArrayHelper::merge(
              parent::ruleBlockedFields(),
               $reglas );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
       return [
            'codcen' => Yii::t('base.names', 'Codcen'),
            'nomcen' => Yii::t('base.names', 'Nomcen'),
           // 'codsoc' => Yii::t('base.names', 'Codsoc'),
            'descricen' => Yii::t('base.names', 'Descricen'),
        ];
        //return  parent::ruleBlockedFields();
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocio()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    public function getAlmacenes()
    {
        return $this->hasMany(Almacenes::className(), ['codcen' => 'codcen']);
    }
    
    /*public function getDocumentos()
    {
        return $this->hasMany(Documentos::className(), ['codocu' => 'codocu']);
    }
    */
    public function afterSave($insert,$changedAttributes){
        //if($insert)
        //$this->loadParametros();
        return parent::afterSave($insert,$changedAttributes);
    }
    
   private function loadParametros(){
      $params=Parametros::find()->where(['activo' => '1', 'flag' => '1'])->all();
      $centro=$this->codcen;
      //var_dump($centro);die();
      
      foreach($params as $fila){
          $attributes=['codcen'=>$centro,
              'codparam'=>$fila->codparam];
          Centrosparametros::firstOrCreateStatic($attributes);
      }
   }
    
    public static function keyCache(){
        return self::CURRENT_CENTER_KEY_CACHE;
    }
  
     public static function currentCenter(){
        $cache=h::cache();
        if($cache->exists(self::keyCache()) && !empty(self::keyCache())){
            return $cache->get(self::keyCache());
            
        }else{
            //echo "se foe";die();
          return \yii::$app->controller->redirect(['/profile/select-center'])
         ->send();
        }        
      }
    
    public  function storeCenter(){
       $cache=h::cache();
       $cache->set(self::keyCache(),$this->attributes);
       return $cache->get(self::keyCache());
    }
    
    public static function codcen(){  
        yii::error('INVOCVANDO AL A FUNCION CURRENT_CENTER()',__FUNCTION__);
       $array_company=self::currentCenter();
        yii::error('ARRAY_Center ES:',__FUNCTION__);
        yii::error($array_company,__FUNCTION__);
      
       if(is_array($array_company))
       return $array_company['codcen'];
    } 
   public static function nomcen(){  
        $array_company=self::currentCenter();
       
       if(is_array($array_company))
       return $array_company['nomcen'];
    } 
    
    
}
