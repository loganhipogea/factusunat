<?php
namespace common\behaviors;
use yii;
use common\models\masters\Documentos;
use yii\base\Behavior;

class CodocuBehavior extends Behavior
{
    
    public function codocu($clase=null){
      $rutaClase=(is_null($clase))?$this->owner->className():$clase;
      if(!is_null($registro= Documentos::findOne(['modelo'=>$clase]))){
          return $registro->codocu;
      }else{
        throw new ServerErrorHttpException(Yii::t('models.errors', 'Este clase no está asociada a ningún documento'));
            
      }
    }
   
}