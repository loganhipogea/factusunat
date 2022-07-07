<?php

namespace frontend\modules\com;
use common\helpers\h;
/**
 * com module definition class
 */
class Module extends \yii\base\Module
{
    const SESSION_ID_CURRENT_CASH='idcajadeldia';
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
       if($sesion->has(self::SESSION_ID_CURRENT_CASH)){
           $sesion->remove(self::SESSION_ID_CURRENT_CASH); die();
           $valorSesion=$sesion->get(self::SESSION_ID_CURRENT_CASH);
          // \yii::error('tiene sesion');
           //\yii::error($sesion->get('idcajadeldia'));
           if($valorSesion['fecha']==date('Y-m-d')){
              return $valorSesion['id_caja']; 
           }else{
              $sesion->remove(self::SESSION_ID_CURRENT_CASH); 
              if(is_null($reg=models\ComCajadia::find()->where(['codcen'=>$codcen,'fecha'=>date('Y-m-d')])->one())){
              //yii::error('redireccionado');
                    return h::currentController()->redirect(['/com/com/open-cash'])->send();
                }else{
                        $valores=['id_caja'=>$reg->id+0,'fecha'=>date('Y-m-d')];
                        $sesion->set(self::SESSION_ID_CURRENT_CASH,$valores);
                    return $reg->id;
                }
           }
           
       }else{
           if(is_null($reg=models\ComCajadia::find()->where(['codcen'=>$codcen,'fecha'=>date('Y-m-d')])->one())){
              //yii::error('redireccionado');
               return h::currentController()->redirect(['/com/com/open-cash'])->send();
           }else{
               $valores=['id_caja'=>$reg->id+0,'fecha'=>date('Y-m-d')];
               $sesion->set(self::SESSION_ID_CURRENT_CASH,$valores);
               return $reg->id;
           }
       }
    }
}
