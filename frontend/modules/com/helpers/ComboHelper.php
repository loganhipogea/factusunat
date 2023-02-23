<?php
namespace frontend\modules\com\helpers;
use frontend\modules\com\models\ComFactura;
use frontend\modules\com\models\ComCoticeco;
use frontend\modules\cc\models\CcCc;
USE yii;
use \yii\helpers\ArrayHelper;
class ComboHelper extends \common\helpers\ComboHelper{
    
     public static function getCboCajas($codcen=null){ 
         $query= \frontend\modules\com\models\ComCajaventa::find();
         if(is_null($codcen)){
             
            return ArrayHelper::map($query->all(),
                'id','nombre');
         }else{
           return ArrayHelper::map($query->andWhere(['codcen'=>$codcen])->all(),
                'id','nombre');  
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
    /*public static function getCboFlagSunat(){
       return [
           ComFactura::ST_PASSED_SUNAT=>yii::t('base.names','Aceptada-SUNAT'),
           ComFactura::ST_REJECT_SUNAT=>yii::t('base.names','Rechazada-SUNAT'),
         //  ComFactura::ST_PASSED_SUNAT=>yii::t('base.names','Passed SUNAT'),
           ComFactura::ST_MISSING_SUNAT=>yii::t('base.names','No enviada-SUNAT'),
           ];
    }*/
    
    public static function tiposCecos(){
        return [
            'M'=>'Estadística compras',
            'P'=>'Predefinida',
            'D'=>'Determinística',
        ];
    }
    
    public static function partidasCoti($id_coti){
       return ArrayHelper::map(
                       \frontend\modules\com\models\ComCotigrupos::find()->
               andWhere(['coti_id'=>$id_coti])
               ->all(),
                'id','descripartida');   
    }
    
    public static function cecosCoti($id_coti){
      $idsCecosCoti= ComCoticeco::find()->
                select(['ceco_id'])-> andWhere(['coti_id'=>$id_coti])->column();
      $arreglo= ComCoticeco::find()->alias('t')->
         select(['t.id','b.descripcion'])->
       innerJoin(CcCc::tableName().' as b','t.ceco_id=b.id' )->
       andWhere(['in','b.id', $idsCecosCoti])->
       andWhere(['coti_id'=>$id_coti])->
         asArray()->all();
        
        return array_combine(
                array_column($arreglo,'id'),
                array_column($arreglo,'descripcion')
                );
        
    }
    
    
    public static function cboActivos(){
       return ArrayHelper::map(
                       \frontend\modules\mat\models\MatActivos::find()->all(),
                'codigo','descripcion');    
    }
    
     public static function cboCargosCoti(){
       return ArrayHelper::map(
                       \frontend\modules\com\models\ComCargos::find()->all(),
                'id','descripcion');    
    }
}
