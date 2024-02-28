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

class ActionAjaxStoreSession extends \yii\base\Action
{
	const NOMBRE_CLASE_PARAMETER='modelo';
        const NOMBRE_ATRIBUTO='attr';
	const VALOR_ATTRIBUTO='val';
	
	public function run()
	{
           if (h::request()->isAjax ) {
           h::response()->format = Response::FORMAT_JSON;
        $datos=[];
	$modelClass=h::request()->post(static::NOMBRE_CLASE_PARAMETER);   
        $attribute=h::request()->post(static::NOMBRE_ATRIBUTO); 
        $valor=h::request()->post(static::VALOR_ATTRIBUTO); 
        $model=$modelClass::instance();
        if($model instanceof modelBase && !is_null($model)){
          
                VAR_DUMP($modelClass,$attribute,$valor,h::request()->post());DIE();
                //return ActiveForm::validate($model);
            
             $model->store_sesionAttribute($attribute,$valor);
               $datos['success']=yii::t('base.errors','Se almacenó en la sesión');  
          
                    }else{
                        $datos['error']=yii::t('base.errors','The class : "{clase}" is not Instance of "baseModel" ',['clase'=>$modelClass]);  
                  
                }
            return $datos;
            }
        }
	
}