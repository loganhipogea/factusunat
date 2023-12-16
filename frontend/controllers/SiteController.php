<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
USE common\helpers\h;
use yii\base\UnknownPropertyException;
use mdm\admin\models\searchs\User as UserSearch;
use common\models\masters\VwSociedades;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
     public function actionAddfavorite(){
         $this->layout="install";
        $url=Yii::$app->request->referrer;  
        
        if(!is_null($url)){
            $url=str_replace(\yii\helpers\Url::home(true),'',$url);
           
            $model= new \common\models\Userfavoritos();
            $model->setAttributes([
                            'url'=>$url,
                             'user_id'=>h::userId(),
                                ]);        
          if ($model->load(Yii::$app->request->post()) && $model->save()) {           
           return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
                }        
        return $this->render('favorites', [
            'model' => $model,
        ]);
        }else{
            return;
        }
         
    }
    
    public function actionPio(){
       $model= \frontend\modules\mat\models\MatReq::findOne(50);
        var_dump($model->codest,$model->aprobar(),$model->codest);
        die();
        
        echo date('Y').date('m').date('d');
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
       // $urlBackend=str_replace('frontend','backend',yii::$app->urlManager->baseUrl);
         //if(\backend\components\Installer::readEnv('APP_INSTALLED')=='false'){
                //$this->redirect($urlBackend);             
            //}else{                
                if(yii::$app->user->isGuest){
                    $this->layout="plataforma"; 
                  return  $this->redirect(['site/login']);
                    
                }else{
                       try {
                            $profile=h::user()->profile;
                            $url= $profile->url;
                            $tipo=$profile->tipo;
                            if(empty($url)){
                            $url=h::gsetting('general','url.profile.'.$tipo);  
                                     // yii::error(' url  '.$url); 
                                }
              //yii::error('LA URL ES  '.$url);                   
                                if(!empty($url))
                                 $this->redirect(Url::to([$url]));
                       } catch (UnknownPropertyException $ex) {
                           return $this->render('index');
                       } 
                                                 
                     //return h::user()->resolveUrlAfterLogin();                     
                        
                }               
              // $this->redirect(\Yii::$app->urlManager->home);
            //}
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout="login";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           $current= VwSociedades::currentCompany();
            $this->redirect(Url::toRoute([Yii::$app->user->resolveUrlAfterLogin()]));
           
           //var_dump($current); die();
          //$this->redirect(['index']); 
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    
   public function actionIndexCompanies(){
      return $this->render('index-companies');
   }
   
   
  public function actionMostrarAwe(){
        return $this->render('awe');
    }
  
    
  public function actionRutas()
    {
      
      \frontend\modules\mat\models\MatDetNe::findOne(17)->createOp();DIE();
      
      
      
      echo \common\models\masters\MaestrocompoSol::generateCode('130117');
      die();
      
      echo SUBSTR('T'.\common\helpers\h::userId(). microtime().'',0,9); die();
      
      
      $model=New \frontend\modules\mat\models\MatDetvale();
      $model->setAttributes([
          'vale_id'=>1,
          'um'=>'UN',
          'cant'=>575,
          'codart'=>'100206',
          'punit'=>null,
      ]);
      //PRINT_R($model->activeAttributes()); DIE();
      /*foreach($model->getActiveValidators() as $validator){
         echo  $validator->className()."<br>";
          foreach($validator->attributeNames as $name){
             echo "--->". $name."<br>"; 
          }
          echo "--FIN<br><br>--";
      }*/
     
      VAR_DUMP($model->validate());
   // PRINT_R($model->getErrors());
      DIE();
     
      
      
      
      var_dump($model instanceof \common\interfaces\CosteoInterface); 
      die();
      
      
     
      var_dump(
              \common\models\masters\Documentos::codigoByModelClass(
                      New \frontend\modules\mat\models\MatVale()
                      )
              );
      die();
      
     $model= \common\models\masters\Transadocs::findOne('100');
      
      var_dump($model); 
      die();
      
      $model= \frontend\modules\com\models\ComCotizacion::findOne(74);
      echo $model->getPartidas()->select([
          'a.*','x.id as iddet','x.item as itemdet','x.descripcion as descridet',
          'x.cant','x.punit','x.codum','x.ptotal'
      ])->alias('a')->innerJoin('{{%com_detcoti}} x','a.id=x.cotigrupo_id')
              ->createCommand()->rawSql;
      
      
      die();
      $model=\frontend\modules\com\models\ComCotiversiones::findOne(16);
      PRINT_R($model->mailCotizacion());
      die();
      phpinfo(); 
      die();
      VAR_DUMP(h::tipoCambio('PEN'),h::tipoCambio('USD'));
      DIE();
      
      ECHO 'h::tipoCambio(PEN)  :'.h::tipoCambio('PEN');
      ECHO 'h::tipoCambio(USD)  :'.h::tipoCambio('PEN');
      
     $model= \frontend\modules\com\models\ComCotizacion::findOne(5);
     echo $model->createVersion();
     die();
     print_r($model->array_cargos());
     $model->deleteCache();
     echo '<br>';
     print_r($model->array_cargos());
     die();
      
      
      
      
     print_r(\yii\helpers\FileHelper::findFiles('c:/proyectos/factusunat'));
     die();
      
      
      
      
      
      
      
      
      
      
$html = <<<HTML
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<p>Simple Content</p>
</body>
</html>
HTML;

// create PDF file from HTML content :
return Yii::$app->html2pdf
    ->convert("<b>Hola</b>")    
    ->send();


die();
      $mpdf = new \Mpdf\Mpdf();
      $contenido=' <html lang="es">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-param" content="_csrf-frontend">
        <meta name="csrf-token" content="2jsjgLZ_oXU1eIDXXDcbxaMnHzkU-LhMayOVdgC7REKgYU3x3QzsP3NMsYI7aCnx_GIqaCSB0j4dca04TMEiKQ==">
           </head>             
<title></title>
          <body>
         <div>Solicitud de cotización 5800000002</div>
         <table>
        <TR>
        <TD width="100%" >
            <div >
                <table >
                 <TR style="border-top:solid;border-bottom:solid;border-color:#CCC; border-width: 1px;">
                    <TD style="padding: 7px;">Sres : </TD>
                    <TD style="padding: 7px;">ESPINOZA RIVERA YESENIA ALEJANDRINA</TD>
                 </TR>
                </TABLE>
            </DIV>
        </TD>
       
    </TR>
    
    </table>
        </body></html>';
      $mpdf->WriteHTML($contenido);
      $nombre= uniqid().'pdf';
      $mpdf->Output(yii::getAlias('@temp') .'/'. $nombre, \Mpdf\Output\Destination::INLINE);
      die();
      
        $model=New \frontend\modules\mat\models\MatDetpetoferta();
        echo $model->find()->andWhere([ 'and',
            ['petoferta_id'=>23],
            ['not in','id',[12,34,45]]
                ])->createCommand()->rawSql;
        DIE();
    } 
    
    
    public function actionContenidoWeb(){
        $dataProvider=New \yii\data\ActiveDataProvider([
            'query'=>\frontend\models\AitContenidos::find(),
        ]);
        
        return $this->render('ait_contenido',['dataProvider'=>$dataProvider]);
    }
    
    public function actionModalEditarContenido($id){
        $this->layout="install";
        $model= \frontend\models\AitContenidos::findOne($id);
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_contenido',
                 [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
    
    
    public function actionModalCrearContenido(){
        $this->layout="install";
        $model= new\frontend\models\AitContenidos();
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_contenido',
                 [
                        'model' => $model,
                         //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
    
    
    public function actionModalEditarMenu($id){
        $this->layout="install";
        $model= \frontend\models\AitMenus::findOne($id);
        
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_menu',
                 [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
    
    
    public function actionModalCrearMenu(){
        $this->layout="install";
        $model= new\frontend\models\AitMenus();
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_menu',
                 [
                        'model' => $model,
                         //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
     public function actionMenus(){
        $dataProvider=New \yii\data\ActiveDataProvider([
            'query'=> \frontend\models\AitMenus::find(),
        ]);
        
        return $this->render('ait_menus',['dataProvider'=>$dataProvider]);
    }
    
    
    
    
    
    
    public function actionModalEditarColumna($id){
        $this->layout="install";
        $model= \frontend\models\AitColumnas::findOne($id);
        
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_columna',
                 [
                        'model' => $model,
                         'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
    
    
    public function actionModalCrearColumna(){
        $this->layout="install";
        
        $model= new\frontend\models\AitColumnas();
        
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_columna',
                 [
                        'model' => $model,
                         //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
    public function actionColumnas(){
        $dataProvider=New \yii\data\ActiveDataProvider([
            'query'=> \frontend\models\AitColumnas::find(),
        ]);
        
        return $this->render('ait_columnas',['dataProvider'=>$dataProvider]);
    }
 
   public function actionAjaxExpandColumnas(){
        if (isset($_POST['expandRowKey'])) {
        $model = \frontend\modules\com\models\ComCotiversiones::findOne($_POST['expandRowKey']+0);
         return $this->renderPartial('expand_columnas', ['model'=>$model]);
        }  
        
        
    }   
   
  public function actionCorreolibre(){
      
    // return h::request()->get('email');
       $mailer = new \common\components\Mailer();
            $message =new  \yii\swiftmailer\Message();
            $message->setSubject('NUEVO MENSAJE DE LA WEB')
            ->setFrom([h::gsetting('mail', 'userservermail')])
            ->setTo(h::gsetting('general', 'correo_ventas'))
             ->SetHtmlBody(h::request()->get('mensaje').
                     '<br><br>Nombre:'.h::request()->get('nombre').'<br>'.
                     'Correo:'.h::request()->get('email').'<br>'.
                     'Teléfono:'.h::request()->get('telefono')
                     );           
               
           
            try {        
                $result = $mailer->send($message);
               
                
                return true;
                } catch (\Swift_TransportException $Ste) {      
                 return false;  
                }
      
  }
  
  
   public function actionNoticias(){
        $dataProvider=New \yii\data\ActiveDataProvider([
            'query'=> \frontend\models\AitNoticias::find(),
        ]);
        
        return $this->render('ait_noticias',['dataProvider'=>$dataProvider]);
    }
  
  public function actionModalCrearNoticia(){
        $this->layout="install";
        $model=new  \frontend\models\AitNoticias();
        //$model= new\frontend\models\AitColumnas();
       // $model->contenido_id=$mpadre->id;
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_noticia',
                 [
                        'model' => $model,
                         //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
    
    
  public function actionModalEditarNoticia($id){
        $this->layout="install";
        $model= \frontend\models\AitNoticias::findOne($id);
        //$model= new\frontend\models\AitColumnas();
      
       if(h::request()->isPost){            
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
              // var_dump($datos);die();
               return ['success'=>2,'msg'=>$datos];  
            }else{
                if($model->save()){
                   $model->refresh();
                   return ['success'=>1];  
                }else{                    
                }                
            }
        }else{
        //if(h::request()->isPost){var_dump(h::request()->get('gridName'));die();}
        return $this->render('modal_noticia',
                 [
                        'model' => $model,
                         //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]
                );
        }
    }
}
