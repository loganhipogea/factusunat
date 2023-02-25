<?php

namespace common\models\masters;
use yii\helpers\Url;
use common\helpers\h;
use Yii;
use yii\web\NotFoundHttpException;
/**
 * This is the model class for table "{{%vw_sociedades}}".
 *
 * @property string $codpro
 * @property string $despro
 * @property string $rucpro
 * @property string|null $alias
 * @property string|null $codsoc
 */
class VwSociedades extends \common\models\base\modelBase
{
    
    private $_data=null;
    
    const CURRENT_COMPANY_KEY_CACHE='current_compay4343';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vw_sociedades}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codpro', 'despro', 'rucpro'], 'required'],
            [['codpro'], 'string', 'max' => 6],
            [['despro'], 'string', 'max' => 60],
            [['rucpro'], 'string', 'max' => 15],
            [['alias'], 'string', 'max' => 40],
            [['codsoc'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codpro' => Yii::t('base.names', 'Codpro'),
            'despro' => Yii::t('base.names', 'Despro'),
            'rucpro' => Yii::t('base.names', 'Rucpro'),
            'alias' => Yii::t('base.names', 'Alias'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwSociedadesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwSociedadesQuery(get_called_class());
    }
    
    public static function keyCache(){
        return  self::CURRENT_COMPANY_KEY_CACHE;
    }
    
    /*
     * Retorna un array con attributos 
     * de la sociedad actual
     * [codpro=>'A', DESPRO=>'ANDINA SOCIEDAD ANONIMA', rucpro=>'20600279832']
     */
    public static function currentCompany(){
        $cache=h::cache();
        if($cache->exists(self::keyCache())){
            yii::error('Encontro el key sesion');
          // VAR_DUMP($sesion->get(self::keyCache()));die();
            return $cache->get(self::keyCache());
        }else{
                        
              return  \yii::$app->controller->redirect(['/profile/select-company'])->send();
                          
        }
    }
    /*
     * Almacena la informacion de la empresa 
     * con sus atributos en cache, array 
     * [codpro=>'A', DESPRO=>'ANDINA SOCIEDAD ANONIMA', rucpro=>'20600279832']
     */
    public  function storeCompany($attributes=null){
        $cache=h::cache();
       if(is_null($attributes))$attributes=$this->attributes;
       $cache->set(self::keyCache(),$attributes,60*60*24*365);
       return $cache->get(self::keyCache());
    }
    
    public static function codsoc(){  
        yii::error('inocando a currnetCompany',__FUNCTION__);
        
      $array_company=self::currentCompany();
       //yii::error($array_company,__FUNCTION__);
       if(is_array($array_company)){
           return $array_company['codsoc'];
       }else{
           return null;
       }
       
    } 
    
    public static function codpro(){  
        yii::error('inocando a currnetCompany',__FUNCTION__);
        
       $array_company=self::currentCompany();
       //yii::error($array_company,__FUNCTION__);
       if(is_array($array_company))
       return $array_company['codpro'];
    } 
    public static function rucpro(){      
       $array_company=self::currentCompany();
       if(is_array($array_company))
       return $array_company['rucpro'];
    } 
    public static function despro(){      
      $array_company=self::currentCompany();
       //var_dump($array_company);die();
       if(is_array($array_company))
       return $array_company['despro'];
    } 
  public static function getData(){        
            return self::prepareData();
        
    }
    
    private static function prepareData(){
        $dependency=New \yii\caching\DbDependency(['sql'=>'SELECT COUNT(*) FROM {{%centros}}']);
        $result = self::getDb()->cache(
                                             function ($db) {                                               
                                                return  self::find()->asArray()->all();
                                                        }, 
                                    60*60*24*365,
                                    $dependency);
       return  $result;
    }
    
   public static function societyList($except=false){
       $data=self::prepareData();
       $data=array_combine(array_column($data,'codsoc'),
      array_column($data,'despro')
              );
       if($except && array_key_exists(self::codsoc(), $data)){
           unset($data[self::codsoc()]);
       }
     RETURN   $data;
   }
   
   public static function companiesList($except=false){
     $data=self::prepareData();
     //VAR_DUMP($data);DIE();
       $data=array_combine(array_column($data,'codpro'),
      array_column($data,'despro')
              );
       $cache=h::cache(); 
       if($cache->exists(self::keyCache()) && $except && array_key_exists(self::codpro(), $data)){
           unset($data[self::codpro()]);
       }
     RETURN   $data;
   }
  public static function currentCompanyModel(){
       return VwSociedades::find()->andWhere(['codsoc'=>self::codsoc()])->one();
  }  
  
  public function renderLogo(){
      return h::currentController()->renderFile(
              yii::getAlias('@common/view/sociedades/logo.php'),
              ['model'=>$this]
              );
  }
}
