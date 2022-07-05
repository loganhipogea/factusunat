<?php

namespace frontend\modules\com;
use common\helpers\h;
/**
 * com module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\com\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public static function idCajaDia($codcen){
       $sesion=h::session();
      // \yii::error('moduilir');
       if($sesion->has('idcajadeldia')){
          // \yii::error('tiene sesion');
           //\yii::error($sesion->get('idcajadeldia'));
           return $sesion->get('idcajadeldia')+0;
       }else{
           if(is_null($reg=models\ComCajadia::find()->where(['codcen'=>$codcen,'fecha'=>date('Y-m-d')])->one())){
             // yii::error('redireccionado');
               return h::currentController()->redirect(['/com/com/open-cash'])->send();
           }else{
               //YII::ERROR($reg);
               $sesion->set('idcajadeldia',$reg->id+0);
               return $reg->id;
           }
       }
    }
}
