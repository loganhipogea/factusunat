<?php
namespace frontend\modules\com\helpers;
use frontend\modules\com\models\ComFactura;
USE yii;
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
    
    public static function getCboEstadosFactu(){
       return [
           ComFactura::ST_CANCELED=>yii::t('base.names','Removed'),
           ComFactura::ST_PASSED=>yii::t('base.names','Passed'),
         //  ComFactura::ST_PASSED_SUNAT=>yii::t('base.names','Passed SUNAT'),
           ComFactura::ST_CREATED=>yii::t('base.names','Created'),
           ];
    }
    public static function getCboFlagSunat(){
       return [
           ComFactura::ST_PASSED_SUNAT=>yii::t('base.names','Aceptada-SUNAT'),
           ComFactura::ST_REJECT_SUNAT=>yii::t('base.names','Rechazada-SUNAT'),
         //  ComFactura::ST_PASSED_SUNAT=>yii::t('base.names','Passed SUNAT'),
           ComFactura::ST_MISSING_SUNAT=>yii::t('base.names','No enviada-SUNAT'),
           ];
    }
}
