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

    
    public function actionPio(){
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
           $this->redirect(['index']); 
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
    
}
