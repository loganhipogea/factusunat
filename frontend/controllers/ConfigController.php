<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
USE common\helpers\h;
use common\models\masters\Setting;
use yii\base\UnknownPropertyException;
use yii\base\Model;


/**
 * Site controller
 */
class ConfigController extends Controller
{
    /**
     * {@inheritdoc}
     */
   

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    
   public function actionSettingsModule(){
       $moduleId=h::request()->get('module');
       if(yii::$app->hasModule( $moduleId)){
           $items=Setting::find()->andWhere(['section'=>$moduleId])->all();
           //$items=$this->getItemsToUpdate();
    if (Model::loadMultiple($items, Yii::$app->request->post()) && 
        Model::validateMultiple($items)) {
        $count = 0;
        foreach ($items as $item) {
           // populate and save records for each model
            if ($item->save()) {
                // do something here after saving
                $count++;
            }
        }
        Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
        return $this->redirect(['/'.$moduleId.'/default']); // redirect to your next desired page
    } else {
        return $this->render('params_module',['items'=>$items]);
    }
           
           
           
           
           
       }else{
          throw new BadRequestHttpException(yii::t('base.errors','Module {module} doesn\'t exists',['module'=>$moduleId])); 
       }
   }
    
   public function actionAjaxSaveParameter($id){
       if (h::request()->isAjax) {
           $valores=h::request()->post();
           $model= Setting::findOne($id);
           $model->setAttributes([
               'value'=>h::request()->post('valor'),
               'description'=>h::request()->post('descripcion')
           ]);
            h::response()->format = yii\web\Response::FORMAT_JSON;  
           if($model->save()){
               return ['success'=>yii::t('base.errors','Se guardaron los valores')];
           }else{
               return ['error'=>yii::t('base.errors',$model->getFirstError())]; 
           }
            //$id=h::request()->get('valorInput');
           // var_dump($val);die();
            //$model = \frontend\modules\logi\models\LogiVwStock::find()->andWhere(['id'=>$id])->one();
            
             
            
         }   
   } 
    
 
   
    
}
