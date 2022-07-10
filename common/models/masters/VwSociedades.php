<?php

namespace common\models\masters;
use yii\helpers\Url;
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
    
    
    public static function currentCompany(){
        $sesion=\yii::$app->session;
        if($sesion->has(self::CURRENT_COMPANY_KEY_SESION) && !empty($sesion->get(self::CURRENT_COMPANY_KEY_SESION))){
           // VAR_DUMP($sesion->get(self::CURRENT_COMPANY_KEY_SESION));DIE();
            return $sesion->get(self::CURRENT_COMPANY_KEY_SESION);
        }else{
           $sesion->set('permiso',true);
            return \yii::$app->controller->redirect(['/profile/select-company'])
            ->send();
        }        
    }
    
    
    public  function storeCompany(){
       $sesion=\yii::$app->session;
       $sesion->set(self::CURRENT_COMPANY_KEY_SESION,$this->attributes);
       return $sesion->get(self::CURRENT_COMPANY_KEY_SESION);
    }
    
    public static function codsoc(){      
       $array_company=self::currentCompany();
       if(is_array($array_company))
       return $array_company['codsoc'];
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
    
}
