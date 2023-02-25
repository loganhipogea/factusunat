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
USE common\models\masters\VwSociedades;
use yii\base\UnknownPropertyException;
use yii\web\NotFoundHttpException;
use mdm\admin\models\searchs\User as UserSearch;

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
         $cache=h::cache();
         $model=\common\models\masters\VwSociedades::find(['codpro'=>$codpro])->one();
         $model->storeCompany();
         $cache->delete(\common\models\masters\Centros::keyCache());
         $sesion=h::session();
         $url=$sesion->has('mi-ex-url')?$sesion->get('mi-ex-url'):\Yii::$app->request->referrer;
         $sesion->remove('mi-ex-url');         
         $sesion->setFlash('success',yii::t('base.names','Company {company} was selected',['company'=>$model->despro]));
        return  $this->redirect($url)->send();
         
     }else{
       throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$codpro));    
            
     }
     
    
  }
  
  public function actionSelectCenter(){
      $codpro=null; 
      if(\yii::$app->session->has(\common\models\masters\VwSociedades::keysesion()))
          $codpro=\common\models\masters\VwSociedades::codpro(); 
      //echo $codpro; die();
      return $this->render('index-centers',['codpro'=>$codpro]);
    }
    
    
   public function actionSetCenter(){
       $codcen=h::request()->get('codcen',null);
       
     if(!is_null($codcen)){
         $sesion=\yii::$app->session;
         $model= \common\models\masters\Centros::find()->andWhere(['codcen'=>$codcen])->one();
         $model->storeCenter();
         (new VwSociedades())->storeCompany($model->socio->attributes);
         $url=$sesion->get('mi-ex-url');
         $sesion->remove('mi-ex-url');
         UserSociedades::assignCenterToUser(h::userId(), $codcen);
         $sesion->setFlash('success',yii::t('base.names','Center {center} was selected',['center'=>$model->nomcen]));
        return  $this->redirect($url)->send();
         
     }else{
       throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$codcen));    
            
     }
    }
    
    
    
    
    
    
   
     public function actionSelectCompany(){
         yii::error('ingresando al controlador',__FILE__);
      return $this->render('index-sociedades');
    }
    
    
    /*
     * ESTA FUNCION ASIGNA EL CENTRO A UN USUARIO ESPEFICO
     * A DIFERENCIA DE SET-CENTER; TRABAJA CON UN ID DE USUARIO
     * ESPECIFICO Y NO TIENE NADA QUE VER CON EL ALMACENAMIENTO
     * DE SESION, ES MAS POR UN TEMA DE PERMISOS A NIVEL DE TABLA
     */
    
    public function actionAjaxAssignCenterUser($id){
       
         if(h::request()->isAjax){
          $model=UserSociedades::findOne($id);          
           h::response()->format = Response::FORMAT_JSON; 
           if(is_null($model))
            throw new NotFoundHttpException(Yii::t('base.errors', 'No existe el registro para este id '.$id));    
           
            $model->activo=!$model->activo;$model->save();
           if($model->activo)
             return ['success'=>Yii::t('base.names', 'Assign successfully')];
           if(!$model->activo)
             return ['warning'=>Yii::t('base.names', 'Revoke successfully')];
        
           
         }
    }
     
    public function actionManageUsers(){
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
   }
   
   public function actionEditProfile($id){
       
     if($id==h::userId()){
         $newIdentity=h::user()->identity->findOne($id);
          if(!h::request()->isPost)
         \common\models\UserSociedades::createCentersForUser($id);
        // echo get_class_methods($newIdentity);die();
      if(is_null($newIdentity))
          throw new BadRequestHttpException(yii::t('base.errors','User not found with id '.$iduser));  
        $profile =$newIdentity->getProfile($id);
        $profile->setScenario($profile::SCENARIO_INTERLOCUTOR);
        if(h::request()->isPost){
            $arrpost=h::request()->post();
            $profile->tipo=$arrpost[$profile->getShortNameClass()]['tipo'];
            $profile->codtra=$arrpost[$profile->getShortNameClass()]['codtra'];
            $newIdentity->status=$arrpost['User']['status'];
          if (h::request()->isAjax) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($profile);
             }
           if ($profile->save() && $newIdentity->save()) {               
            return $this->redirect(['manage-users']);
           }
            //var_dump(h::request()->post());die();
          }
        //echo $model->id;die();
       // var_dump(UserFacultades::providerFacus($iduser)->getModels());die();
        return $this->render('_formtabs', [
            'profile' => $profile,
            'model'=>$newIdentity,
            //'userfacultades'=> UserFacultades::providerFacusAll($iduser)->getModels(),
        ]);
     }else{
      throw new BadRequestHttpException(yii::t('base.errors','No puede editar un perfil que no es el suyo'));   
     }
   } 
    
    public function actionProfile(){
        
       // echo \common\helpers\FileHelper::getUrlImageUserGuest();die();
     /* if(h::app()->hasModule('sta')){
          $this->redirect(\yii\helpers\Url::toRoute('/sta/default/profile'));
      }*/
        $model =Yii::$app->user->getProfile() ;
        
        $identidad=Yii::$app->user->identity;
        $identidad->setScenario($identidad::SCENARIO_MAIL);
       // var_dump($model);die();
        if ($identidad->load(Yii::$app->request->post()) && $identidad->save() &&                
                $model->load(Yii::$app->request->post()) && $model->save()) {
           // var_dump($model->getErrors()   );die();
            yii::$app->session->setFlash('success','grabo');
            return $this->redirect(['profile', 'id' => $model->user_id]);
        }else{
           // var_dump($model->getErrors()   );die();
        }

        return $this->render('profile', [
            'identidad'=>$identidad,
            'model' => $model,
        ]);
    }
    
    public function actionHashUser(){
      
       if(h::request()->isAjax){
           h::response()->format = \yii\web\Response::FORMAT_JSON;
           $prof=h::user()->identity->profile;
           $prof->hash=$prof->generateHash();
           $prof->save();
           return ['success'=>yii::t('base.names','Se generó el hash')];
        }
  }
 
}
