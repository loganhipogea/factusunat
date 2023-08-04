<?php
namespace common\behaviors;
use yii;
use common\models\masters\Documentos;
use yii\base\Behavior;
use yii\web\ServerErrorHttpException;

class CodocuBehavior extends Behavior
{
    
    public function codocu($clase=null){
      $rutaClase=(is_null($clase))?$this->owner->className():$clase;
      yii::error($rutaClase,__FUNCTION__);
      if(!is_null($registro= Documentos::findOne(['modelo'=>'\\'.$rutaClase]))){
          return $registro->codocu;
      }else{
        throw new ServerErrorHttpException(Yii::t('base.errors', 'Este clase {clase} no está asociada a ningún documento con código {codocu}',['clase'=>$rutaClase]));
            
      }
    }
   
}