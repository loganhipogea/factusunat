<?php
namespace frontend\controllers;
  // use Carbon\Carbon;
use Yii;
use yii\web\NotFoundHttpException;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\TlbotUsers;
USE common\helpers\h;
use yii\helpers\Json;


use yii\base\UserException;
//use yii\filters\VerbFilter;
//use yii\web\Controller;
use yii\web\ForbiddenHttpException;
//use yii;
/*define('API_KEY', \Yii::$app->modules['telegram']->API_KEY);
define('BOT_NAME', \Yii::$app->modules['telegram']->BOT_NAME);
define('hook_url', \Yii::$app->modules['telegram']->hook_url);
define('PASSPHRASE', \Yii::$app->modules['telegram']->PASSPHRASE);*/
/*
 * Hata a qui las pruebnas e telegran
 */


use yii\helpers\Url;
use yii\web\Response;
/**
 * Site controller
 */
class TlbotController extends \frontend\controllers\base\baseController
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                    'destroy-chat' => ['post'],
                    'init-chat' => ['post'],
                    'nxguyu' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
   
  public function init(){
      parent::init();
      
      
  }
  
  public function actionInitChat(){
      /*if(!TlbotUsers::find()->andWhere(['user_id'=>h::userId()])->exists()){
         $msg=yii::t('base.errors','Usted no se encuentra registrado, para hacer mensajes, use el bot para registrarse');
        $chat_id=
         
      }*/
      
      $id_chat_destino=(integer)h::request()->post('chat_id_destino');
     
      $msg='Hola';
      $direc=0;
      $mod=TlbotUsers::find()->andWhere(['user_id'=>h::userId()])->one();
      $chat_id=$mod->chat_id;
      $title=$mod->name;
       if(!TlbotUsers::find()->andWhere(['chat_id'=>$id_chat_destino])->exists()){
          $msg=yii::t('base.errors','Este destinatario no se encuentra registrado, para enviarle mensajes, indíquele que use el bot para registrarse');
       $id_chat_destino=$chat_id;
       $direc=1;
       }
         $telegram=yii::$app->telegram;
      $telegram->iniChat($chat_id,$id_chat_destino,$msg,$direc); 
      return $this->renderPartial('chat',['title'=>$title,'chat_id_destino'=>$id_chat_destino]);
  }
 
  public function actionGetAllMessages(){
      $chat_id_destino=(integer)h::request()->post('chat_id_destino');
     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
     $telegram=yii::$app->telegram;
     $chat_user_id=$telegram->chatIdUser;
     if(is_null($chat_user_id))return false;
     $messages=$telegram->getAllMessagesForChatId($chat_user_id,$chat_id_destino);
     
     if (!empty($messages)) return $messages;
     return false;  

  }
  
   public function actionGetLastMessages()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $postData = \Yii::$app->request->post();
        $telegram=yii::$app->telegram;
        $chat_user_id=$telegram->chatIdUser;
       
        
        
        if(is_null($chat_user_id))return false;
            if(is_null($model=\common\models\TlbotHooks::find()->andWhere(
              ['chat_id'=>$chat_user_id, 'esfinal'=>0,'chat_id_recept'=>$postData['chat_id_destino']]
              )->andWhere(['>','chat_id_recept',0])->one()))return false;
             //yii::error('$postData[lastMsgTime]',__FUNCTION__);
             //yii::error($postData['lastMsgTime'],__FUNCTION__);
             
            yii::error(\common\models\TlbotMessages::find()->where(['hook_id' => $model->id])->andWhere(['>', 'time', $postData['lastMsgTime']])->createCommand()->rawSql);
            $messages = \common\models\TlbotMessages::find()->where(['hook_id' => $model->id])->andWhere(['>', 'time', $postData['lastMsgTime']])->asArray()->all();
        
        if (!empty($messages)) return $messages;

        return false;
    }
  public function actionSendMsg()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $postData = \Yii::$app->request->post();
        $telegram=yii::$app->telegram;
        $texto =$telegram::prefijochat().htmlentities($postData['message']);
        
        $chat_id=$telegram->chatIdUser;
        $chat_id_destino=$postData['chat_id_destino'];
        if($hook=$telegram->isInDuoChat($chat_id)){
           $telegram->sendMessage([
                        'chat_id' =>$chat_id_destino,
                            'text' => $texto,
               'parse_mode'=>'HTML'
                            ]);
           $telegram->insertChat($hook->id,$chat_id,$chat_id_destino,0,$texto); 
        }
        //var_dump($postData);die();
        $postData['time']=date('Y-m-d H:i:s');
        return $postData;
    }
    
     public function actionNxguyu(){
       
      $telegram=Yii::$app->telegram;
            
       $es_lisura=false;
       $update = json_decode(file_get_contents("php://input"), TRUE);
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
            yii::error('te,  input');
            yii::error('holas');
            yii::error($update);
            //yii::error('holis dsds',__FUNCTION__);
            //$telegram->removeSesion();die();
            if(!$telegram->filterCommand())return;
            $telegram->interpretaComandos();
            /*$input=$telegram->input;
            $chatId=$input->message->chat->id;
            $message=$input->message->text;*/
             //$chatId =  $update["message"]["chat"]["id"];
             //YII::ERROR('El chart id es ',__FUNCTION__);
             //YII::ERROR($chatId,__FUNCTION__);
             //$message = $update["message"]["text"]; 
              /*$opts =[ "inline_keyboard"=> [[["text"=> "A","callback_data"=> "A1",], 
                [ "text"=> "B","callback_data"=> "C1"]]]];
              $this->sendMessage($chatId,'Escoje uno de estos valores',$opts);
               */
          /* $res = $telegram->sendMessage([
            'chat_id' =>$chatId ,
            'text' => 'Escribiste esto : '.$message,
                            ]);*/
                                
      }
       
       // $client= \common\models\MediaApps::findOne(13)->client;
       
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
       //$es_lisura=false;
       //yii::error('en la funcion bot -telegram gh');
       
      // $update = json_decode(file_get_contents("php://input"), TRUE);
       //var_dump($update);die();
       
        /*if(array_key_exists('callback_query', $update)){
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
        
       */
           
       
        
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
    public function actionIniChatPopup($id){
    if(h::request()->isAjax){
       if(!is_null($model=TlbotUsers::find()->
               andWhere(['tallerdet_id'=>$id])->one())){
                   
                    //var_dump($name);die();
                    return  $this->renderAjax('render_chat_window',['title'=>$model->name,'chat_id_destino'=>$model->chat_id]); 
           
                   }else{
                        h::response()->format = \yii\web\Response::FORMAT_JSON;           
                        return ['error'=>yii::t('base.labels','Este alumno no está afiliado al proveedor de mensajería')];      
              }
            }
        }
   public function actionDestroyChat()
    {
        return '';
    }
}