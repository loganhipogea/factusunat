<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */

namespace frontend\modules\telegram\controllers;

use common\longman\TelegramBot\Exception\TelegramException;
use common\longman\TelegramBot\Telegram;
use yii\base\UserException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii;
define('API_KEY', \Yii::$app->modules['telegram']->API_KEY);
define('BOT_NAME', \Yii::$app->modules['telegram']->BOT_NAME);
define('hook_url', \Yii::$app->modules['telegram']->hook_url);
define('PASSPHRASE', \Yii::$app->modules['telegram']->PASSPHRASE);


/**
 * Default controller for the `telegram` module
 */
class DefaultController extends Controller
{
 public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'destroy-chat' => ['post'],
                    'init-chat' => ['post'],
                    'hook' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {            
        if ($action->id == 'hook') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionDestroyChat()
    {
        return $this->renderPartial('button');
    }
    public function actionInitChat()
    {
        $session = \Yii::$app->session;
        if(!$session->has('tlgrm_chat_id')) {
            if (isset($_COOKIE['tlgrm_chat_id'])) {
                $tlgrmChatId = $_COOKIE['tlgrm_chat_id'];
                $session->set('tlgrm_chat_id', $tlgrmChatId);
            } else {
                $tlgrmChatId = uniqid();
                $session->set('tlgrm_chat_id', $tlgrmChatId);
                setcookie("tlgrm_chat_id", $tlgrmChatId, time() + 1800);
            }
        }
        return $this->renderPartial('chat');
    }

    public function actionSetWebhook(){
        try {
            // Create Telegram API object
            $telegram = new Telegram(API_KEY, BOT_NAME);

            if (!empty(\Yii::$app->modules['telegram']->userCommandsPath)){
                if(!$commandsPath = realpath(\Yii::getAlias(\Yii::$app->modules['telegram']->userCommandsPath))){
                    $commandsPath = realpath(\Yii::getAlias('@app') . \Yii::$app->modules['telegram']->userCommandsPath);
                }
                if(!is_dir($commandsPath)) throw new UserException('dir ' . \Yii::$app->modules['telegram']->userCommandsPath . ' not found!');
            }
            
            // Set webhook
            $result = $telegram->setWebHook(hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
        return null;
    }
    public function actionUnsetWebhook(){
        if (\Yii::$app->user->isGuest) throw new ForbiddenHttpException();
        try {
            // Create Telegram API object
            $telegram = new Telegram(API_KEY, BOT_NAME);

            // Unset webhook
            $result = $telegram->unsetWebHook();

            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }

    public function actionHook(){
        \Yii::error('entrando al hook',__FUNCTION__);
        
        $this->enableCsrfValidation = false;
        try {
            // Create Telegram API object
            $telegram = new Telegram(API_KEY, BOT_NAME,__FUNCTION__);
            $basePath = \Yii::$app->getModule('telegram')->basePath;
//            $commandsPath = realpath($basePath . '/Commands/SystemCommands');
            $commandsPath = realpath($basePath . '/Commands/UserCommands');
            $telegram->addCommandsPath($commandsPath);
            yii::error(\Yii::$app->modules['telegram']->userCommandsPath);
            
            if (!empty(\Yii::$app->modules['telegram']->userCommandsPath)){
                if(!$commandsPath = realpath(\Yii::getAlias(\Yii::$app->modules['telegram']->userCommandsPath))){
                    $commandsPath = realpath(\Yii::getAlias('@app') . \Yii::$app->modules['telegram']->userCommandsPath);
                }
                $telegram->addCommandsPath($commandsPath);
            }
            // Handle telegram webhook request
            $telegram->handle();
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            var_dump($e->getMessage());
        }
        return null;
    }
    
   public function actionIndex(){
       return true;
   }
    
   public function actionBotTelegram(){
        $client= \common\models\MediaApps::findOne(13)->client;
       
        /*$update=$client->httpClient->post(
       \yii\helpers\Url::current([],true),
        [],   
        [ 
            "Content-Type" => "application/json",
          ]
        )->send()->getData();
       yii::error($update,__FUNCTION__);*/
       
      //$this->enableCsrfValidation=false;
      // yii::error('url telegram',__FUNcTION__);
       $es_lisura=false;
       //yii::error('en la funcion bot -telegram gh');
       
       $update = json_decode(file_get_contents("php://input"), TRUE);
       //var_dump($update);die();
       
        if(array_key_exists('callback_query', $update)){
            YII::ERROR('CALLBACK',__FUNCTION__);
            YII::ERROR($update['callback_query'],__FUNCTION__);
             $chatId = $update["callback_query"]["id"];
            $message = $update["callback_query"]["message"];
            switch($update['callback_query']['data']){
                                case "A1":
                                   YII::ERROR('case1',__FUNCTION__); 
                                $this->sendAnswer($chatId, "A");
                                 break;
                                case "C1":
                                    YII::ERROR('case2',__FUNCTION__); 
                                $this->sendAnswer($chatId, "b");
                                break;
                                default:
                                    YII::ERROR('case3',__FUNCTION__); 
                                $this->sendAnswer($chatId, "NADA");
                                break;
                            }
        }ELSEIF(array_key_exists('message', $update)){
             $chatId =  $update["message"]["chat"]["id"];
             YII::ERROR('El chart id es ',__FUNCTION__);
             YII::ERROR($chatId,__FUNCTION__);
             $message = $update["message"]["text"]; 
              $opts =[ "inline_keyboard"=> [[["text"=> "A","callback_data"=> "A1",], 
                [ "text"=> "B","callback_data"=> "C1"]]]];
              $this->sendMessage($chatId,'Escoje uno de estos valores',$opts);
        }
        
       
           
       
        
         /*$array_lisuras=[' mierda ',' carajo ',' puta ',' pvta ',' ctmr ',
             ' ctmre ',' mrd ',' conchatumare ',' conchatumadre ',
             ' concha tumare ',' concha tu madre ',' concha tu mare ',
             ' chatumare ',' idiota ',' baboso ',' imbécil ',' imbecil ', 
          
             ];
        foreach($array_lisuras as $key=>$palabra){
            if (!(strpos(strtolower($message), strtolower($palabra)) === false) or 
                 !(strpos(strtolower($message), trim(strtolower($palabra))) === false 
                   )   
                    ){
              $es_lisura=true;
              break;
            }
        }
         if($es_lisura){
          $message='lisura';   
         }
        */
        /*$resp=$client->respuesta($message);
        if(strlen($resp)==0)$resp='No entendí nada';*/
       
        
     
      
       //$cliente=\common\models\MediaApps::findOne(13)->client;
       //$respuesta=$cliente->sendMessage($chatId,$message);
       //var_dump($respuesta);
   }
   
   public function sendMessage($chatId, $mensaje,$options=null){
       //yii::error('enviando mensaje',__FUNCTION__);
       if(!is_null($options)){
           $cad='&reply_markup='.Json::encode($options);
       }else{
         $cad='';  
       }
      $url=  'https://api.telegram.org/bot1998372478:AAFjQWSgcWlhJJkfhd4mWrpBSN7jRw0KFEg/sendMessage?chat_id='.$chatId.'&text='. urlencode($mensaje).$cad;
      file_get_contents($url);
   }
   public function sendAnswer($chatId, $mensaje){
       
      $url=  'https://api.telegram.org/bot1998372478:AAFjQWSgcWlhJJkfhd4mWrpBSN7jRw0KFEg/answerCallbackQuery?callback_query_id='.$chatId.'&text='. urlencode($mensaje);
      file_get_contents($url);
   }
   
}
