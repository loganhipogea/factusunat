<?php
/*
 * Esta clase extiende la clase original
 * pero adicionalmetne devuelve los data
 * para los combos  
 * FACULTADES
 * CARRERAS
 * CARRERAS POR FACULTAD
 */
namespace frontend\modules\mat\helpers;
use yii\helpers\ArrayHelper;
use common\helpers\ComboHelper as Combito;
use common\helpers\h;
use frontend\modules\mat\models\MatDetreq;
use yii;
class comboHelper extends Combito
{
    
    public static function getCboTransaccionesAlmacen(){
       return ArrayHelper::map(
                       \common\models\masters\Transacciones::find()->
                  all(),
                'codtrans','descripcion');
        
    }
    
     public static function getCboTransaccionesDepuradasAlmacen(){
       return ArrayHelper::map(
                       \common\models\masters\Transacciones::find()->
               andWhere(['NOT LIKE','descripcion','[X]'])->
                  all(),
                'codtrans','descripcion');
        
    }
    
    public static function getCboColectores(){
         //$idsEdificios= ;
        return [
            'BOV20191000001'=>'Montaje de Tornillo helicoidal',
'BOV20191000002'=>'Sumini y monta. Línea Filtrado FPL3 ',
'BOV20191000004'=>'FAB.DESM Y MONT RACK Y SOPOR 3ER NIVEL ',
'BOV20191000005'=>'DESMONTAJE Y MONTAJE DE RACKS PUENTE PASARELLA FBC',
'BOV20191000003'=>'SRV.MANTTO TUBOS TITANIO SATURAD.02R001A',
'BOV20191000006'=>'SRV. CAMBIO TORNILLO SINFÍN SC-504',
'BOV20191000007'=>'SISTEMA DE AGITACION DE POZA-MODULO 1B',
'BOV20191000008'=>'GIROSCOPICO',
'BOV20191000013'=>'CARRUSEL',
'BOV20191000009'=>'SUMINISTRO MONTAJE BARANDA SEGURIDAD E06',
'BOV20191000010'=>'SRV. ADIC CAMBIO TORNILLO SC-504',
'BOV20191000011'=>'SRV.DESMONTAJE/MONTAJE BOMBA P-151',
'BOV20191000012'=>'FAB. LINEAS SUCCION A F-502',
'BOV20191000014'=>'SRV. INSTALACION BANDEJAS F.BANDA F-140',
'BOV20191000015'=>'DESMONTAJE DE 2 TANQUES',
'BOV20191000017'=>'TRASLADO DE EQUIPOS METALICOS A LEPSA ',
'BOV20191000018'=>'SERV. FAB. Y CAMBIO DE EJE EN SC-141',
'BOV20191000019'=>'SRV.RECTIFICADO EJE REDUCTOR TF-502',
'BOV20191000019'=>'BOCINA PORTASELLO INOX ',
'BOV20191000020'=>'MANTTO GRUPO ELECTROGENO CUMMIS',
'BOV20191000021'=>'TRABAJOS ADICIONALES DE MANTENIMIENTO GRUPO ELECTROGENO 220KW CUMMNIS',
'BOV20191000022'=>'COMPUERTA',
'BOV20191000023'=>'ABRAZADERAS',
'BOV20191000024'=>'AUTOCLAVES',

            ];
        
    }
    
    
   public static function getCboTransaccionesDocus($codmov){
       return ArrayHelper::map(
       \frontend\modules\com\models\MatVwTransadocs::find()->andWhere([
           //'codocu'=>$codocu,
           'codtrans'=>$codmov,
       ])->
                  all(),
                'codocu','desdocu');
        
    } 
    
    public static function getCboCalifMat($codmov){
      return [
          ''
      ];
        
    }  
    public static function getCboProyectosAbiertos(){
        $equipos=[
            'EQ ANFO LOADER #3',
            'EQ ANFO LOADER #2',
            'EQ ROCK BREAKER #1',
            'EQ TRITON DFDF20 2 BRAZOS',
            'EQ NAUTILUS 2R LITTLE',
            'EQ TRITON DD311',
            ];
      return array_combine($equipos,$equipos);
    }
}

