<?php
namespace common\actions;
use common\helpers\h;
use common\models\base\modelBase;
use yii;
use yii\web\Response;
/* 
 *borr cualquier tipo de modelo
 * pero antes s efija si tinene hijos 
 */

class ActionAjaxDeleteSession extends \yii\base\Action
{
	const NOMBRE_CLASE_PARAMETER='modelo';
        const NOMBRE_ATRIBUTO='attr';
	
	
	public function run()
	{
          if (h::request()->isAjax ) {
           h::response()->format = Response::FORMAT_JSON;
           
        $datos=[];
	$modelClass=unserialize(h::request()->get(static::NOMBRE_CLASE_PARAMETER));   
        $attribute=unserialize(h::request()->get(static::NOMBRE_ATRIBUTO)); 
        
        $model=$modelClass::instance();
        if($model instanceof modelBase && !is_null($model)){
           
             $model->delete_sesionAttribute($attribute);
               $datos['success']=yii::t('base.errors','Se borró en la sesión');  
          
        }else{
          $datos['error']=yii::t('base.errors','The class : "{clase}" is not Instance of "baseModel" ',['clase'=>$modelClass]);  
                  
        }
            
       
            //$datos['success']="TODO OK";
       //$data = 'Some data to be returned in response to ajax request';
   // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $datos;
       
           }
        }	
}