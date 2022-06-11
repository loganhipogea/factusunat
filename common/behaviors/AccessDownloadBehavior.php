<?php
/**
 * Created by Jramirez
 * User: Алимжан
 * Date: 20.11.2018
 * Time: 12:24
 */

namespace common\behaviors;
use yii;
use yii\base\Behavior;
use yii\helpers\Json;
use common\models\AccesDocu;
use common\helpers\h;
//use yii\db\ActiveRecord;
use yii\web\ServerErrorHttpException;
use common\models\base\modelBase as Base;

class AccessDownloadBehavior extends Behavior
{
 const FIELD_NAME='codocu';  
   
    
  private function ValidateBehavior(){
      $owner=$this->owner;
      if (!$this->owner->hasProperty(self::FIELD_NAME)){
          throw new ServerErrorHttpException(Yii::t('models.errors', 'Este modelo no tiene la propiedad  '.self::FIELD_NAME));
      }
     /* if ($owner instanceof \common\models\base\modelBase){
          throw new ServerErrorHttpException(Yii::t('models.errors', 'Este modelo no es de la instancia de  '.get_class(modelBase)));
      }
      */
  }
  
private function queryBase(){
    $this->ValidateBehavior();
   $owner=$this->owner;
   return   AccesDocu::find()->where([
         'modelo'=>$owner->getShortNameClass(),
         'codocu'=>$owner->{self::FIELD_NAME},
         'profile'=>h::user()->getProfile()->tipo,    
             ]);  
}  
 public function canDownLoad(){
     $query=$this->queryBase()->andWhere(['download'=>'1']);
     return $query->exists();     
 }
 
 public function canUpload(){
     $query=$this->queryBase()->andWhere(['upload'=>'1']);
     return $query->exists();     
 }

public function canDelete(){
     $query=$this->queryBase()->andWhere(['delete'=>'1']);
     return $query->exists();     
 } 
  
}