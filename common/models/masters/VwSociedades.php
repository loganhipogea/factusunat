<?php

namespace common\models\masters;
use yii\helpers\Url;
use common\helpers\h;
use Yii;

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
    
    const CURRENT_COMPANY_KEY_SESION='current_compay';
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
    
    public static function keySesion(){
        return   h::userId().'_'.self::CURRENT_COMPANY_KEY_SESION;
    }
    public static function currentCompany(){
        $sesion=\yii::$app->session;
        if($sesion->has(self::keySesion())){
            yii::error('Encontro el key sesion');
          // VAR_DUMP($sesion->get(self::keySesion()));die();
            return $sesion->get(self::keySesion());
        }else{
             yii::error('NO Encontro el key sesion, redireccionando');
           //$sesion->set('permiso',true);
            return  \yii::$app->controller->redirect(['/profile/select-company']);
            yii::error('despues de redireciconarFi');
             
        }        
    }
    
    
    public  function storeCompany($attributes=null){
       $sesion=\yii::$app->session;
       if(is_null($attributes))$attributes=$this->attributes;
       $sesion->set(self::keySesion(),$attributes);
       return $sesion->get(self::keySesion());
    }
    
    public static function codsoc(){  
        yii::error('inocando a currnetCompany',__FUNCTION__);
        
      $array_company=self::currentCompany();
       //yii::error($array_company,__FUNCTION__);
       if(is_array($array_company))
       return $array_company['codsoc'];
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
       
       if(\yii::$app->session->has(self::keySesion()) && $except && array_key_exists(self::codpro(), $data)){
           unset($data[self::codpro()]);
       }
     RETURN   $data;
   }
  public static function currentCompanyModel(){
     // var_dump(['codsoc'=>self::codsoc()]);die();
     return VwSociedades::find()->andWhere(['codsoc'=>self::codsoc()])->one();
  }  
  
  public function renderLogo(){
      return h::currentController()->renderFile(
              yii::getAlias('@common/view/sociedades/logo.php'),
              ['model'=>$this]
              );
  }
}
