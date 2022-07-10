<?php

namespace frontend\controllers;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;
USE common\helpers\h;
use common\models\UserSociedades;
use yii\base\UnknownPropertyException;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class ProfileController extends \common\controllers\base\baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            
        ];
    }

    
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
       
    }

   
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionAssignCenters($id){
       $user=$this->findUser($id);
       UserSociedades::createCentersForUser($id);
       return $this->render('assign_centers',['model'=>$user]);
        
    }
     
    public function findUser($id){
        if (($model = \common\models\User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('base.names', 'The requested page does not exist.'));
   
    }
    
   public function actionAjaxAssign($id){
     if(h::request()->isAjax){
         $id=h::request()->get('id');
         h::response()->format = Response::FORMAT_JSON; 
         $model= UserSociedades::findOne($id);
         if(is_null($model))
          throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$id));    
          $model->activo=!$model->activo;
          $model->save();
         return ['success'=>Yii::t('base.names', 'Assigned successfully')];
     }
  } 
  
  public function actionAjaxAssignAll($id){
     if(h::request()->isAjax){
         $id=h::request()->get('id');
         h::response()->format = Response::FORMAT_JSON; 
         $model= \common\models\User::findOne($id);
         if(is_null($model))
          throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$id));    
            UserSociedades::assignGodToUser($model->id);
         return ['success'=>Yii::t('base.names', 'Assigned successfully')];
     }
  } 
  
   public function actionAjaxRevokeAll($id){
     if(h::request()->isAjax){
         $id=h::request()->get('id');
         h::response()->format = Response::FORMAT_JSON; 
         $model= \common\models\User::findOne($id);
         if(is_null($model))
          throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$id));    
            UserSociedades::revokeAllToUser($model->id);
         return ['success'=>Yii::t('base.names', 'Revoked successfully')];
     }
  } 
  
  public function actionSetCompany(){
     $codpro=h::request()->get('codpro',null);
     if(!is_null($codpro)){
         $sesion=\yii::$app->session;
         $model=\common\models\masters\VwSociedades::find(['codpro'=>$codpro])->one();
         $model->storeCompany();
         $url=$sesion->get('mi-ex-url');
         $sesion->remove('mi-ex-url');
         $sesion->setFlash('success',yii::t('base.names','Company {company} was selected',['company'=>$model->despro]));
        return  $this->redirect($url)->send();
         
     }else{
       throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$codpro));    
            
     }
     
    
  }
  
  public function actionSelectCenter(){
      return $this->render('index-centers');
    }
    
    
   public function actionSetCenter(){
       $codcen=h::request()->get('codcen',null);
     if(!is_null($codcen)){
         $sesion=\yii::$app->session;
         $model= \common\models\masters\Centros::find(['codcen'=>$codcen])->one();
         $model->storeCenter();
         $url=$sesion->get('mi-ex-url');
         $sesion->remove('mi-ex-url');
         $sesion->setFlash('success',yii::t('base.names','Center {center} was selected',['center'=>$model->nomcen]));
        return  $this->redirect($url)->send();
         
     }else{
       throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$codcen));    
            
     }
    }
   
     public function actionSelectCompany(){
      return $this->render('index-sociedades');
    }
  
}
