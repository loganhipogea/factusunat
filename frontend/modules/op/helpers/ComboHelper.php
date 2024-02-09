<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\op\helpers;
use yii\helpers\ArrayHelper;
//use frontend\modules\mat\helpers\ComboHelper as Combito;
use common\helpers\ComboHelper as Combito;
use common\helpers\h;
use yii;
class ComboHelper extends Combito
{
    
    public static function actividadesOs($idOs){ 
                return ArrayHelper::map(
                                \frontend\modules\op\models\OpOsdet::find()
                ->where(['os_id'=>$idOs])->all(),
                'id','descripcion');
    }
     public static function procesos(){ 
                return ArrayHelper::map(
                                \frontend\modules\op\models\OpProcesos::find()->all()
               ,
                'id','descripcion');
    }
    
    public static function os($proc_id=null){ 
           if(is_null($proc_id))
                return ArrayHelper::map(
                                \frontend\modules\op\models\OpOs::find()->all()
               ,
                'id','descripcion');
         return ArrayHelper::map(
                                \frontend\modules\op\models\OpOs::find()
                                ->andWhere(['proc_id'=>$proc_id])->all()
               ,
                'id','descripcion');   
    }
    
    public static function planes(){ 
                return ArrayHelper::map(
                                \frontend\modules\op\models\OpPlanestarifa::find()->all()
               ,
                'id','codigo');
    }
    
    
    
}


