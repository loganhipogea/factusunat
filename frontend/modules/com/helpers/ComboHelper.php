<?php
namespace frontend\modules\com\helpers;
use \yii\helpers\ArrayHelper;
class ComboHelper extends \common\helpers\ComboHelper{
     public static function getCboCajas($codcen=null){
       if(is_null($codcen)){
          return ArrayHelper::map(
                          \frontend\modules\com\models\ComCajaventa::find()->all(),
                'id','nombre');  
       }else{
           
       }
       
    }
}
