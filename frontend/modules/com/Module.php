<?php

namespace frontend\modules\com;
use common\helpers\h;
use common\filters\FilterCurrentCompany;
use yii;
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
    
     public function behaviors(){
        return[
           /*[
            'class' => FilterCurrentCompany::className(), 
            'except' => [
                
                ],
            ],*/
        ];
    }
    
    private function keysesion(){
        return \common\models\masters\VwSociedades::codsoc().self::SESSION_ID_CURRENT_CASH;
    }
    
    public static function idCajaDia($codcen){
        
       $sesion=h::session();
       
       \yii::error('moduilir');
       if($sesion->has($this->keysesion())){
           //$sesion->remove(self::SESSION_ID_CURRENT_CASH); die();
           $valorSesion=$sesion->get($this->keysesion());
           \yii::error('tiene sesion',__FUNCTION__);
           \yii::error($sesion->get('idcajadeldia'));
           if($valorSesion['fecha']==date('Y-m-d')){
               \yii::error('la sesion es de hoy');
                \yii::error($valorSesion['fecha']);
                \yii::error(date('Y-m-d'));
              return $valorSesion['id_caja']; 
           }else{
                \yii::error('la sesion NO ES DE HOY, REMOVIENDO'); 
                 \yii::error($valorSesion['fecha']);
                \yii::error(date('Y-m-d'));
              $sesion->remove($this->keysesion()); 
              if(is_null($reg=models\ComCajadia::find()->where(['codcen'=>$codcen,'fecha'=>date('Y-m-d')])->one())){
              yii::error('redireccionado NO SE ENCONTRO LA CAJA DEL DIA');
              yii::error(models\ComCajadia::find()->where(['codcen'=>$codcen,'fecha'=>date('Y-m-d')])->createCommand()->rawSql);
                    return h::currentController()->redirect(['/com/com/open-cash'])->send();
                }else{
                     yii::error('si se encontro la caja del dia');
             
                        $valores=['id_caja'=>$reg->id+0,'fecha'=>date('Y-m-d')];
                        $sesion->set($this->keysesion(),$valores);
                    return $reg->id;
                }
           }
           
       }else{
            yii::error('NO hya sesion ',__FUNCTION__);
           if(is_null($reg=models\ComCajadia::find()->where(['codcen'=>$codcen,'fecha'=>date('Y-m-d')])->one())){
              yii::error('redireccionado on se encontro la caja del dia ');
               yii::error(models\ComCajadia::find()->where(['codcen'=>$codcen,'fecha'=>date('Y-m-d')])->createCommand()->rawSql);
             
               return h::currentController()->redirect(['/com/com/open-cash'])->send();
           }else{
               $valores=['id_caja'=>$reg->id+0,'fecha'=>date('Y-m-d')];
               $sesion->set($this->keysesion(),$valores);
               return $reg->id;
           }
       }
    }
}
