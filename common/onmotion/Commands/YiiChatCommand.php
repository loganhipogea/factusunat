<?php
/**
 * @copyright Copyright &copy; Alexandr Kozhevnikov (onmotion)
 * @package yii2-telegram
 * Date: 02.08.2016
 */
namespace common\onmotion\Commands;

use common\onmotion\models\AuthorizedManagerChat;
use common\onmotion\models\Message;
use common\longman\TelegramBot\Entities\InlineKeyboardButton;
use common\longman\TelegramBot\Entities\InlineKeyboardMarkup;
use common\longman\TelegramBot\Request;
use common\longman\TelegramBot\Telegram;
use yii\base\UserException;
use Yii;

class YiiChatCommand
{
    /**
     * {@inheritdoc}
     */
    public static function sendToAuthorized($message)
    {
        $telegram = new Telegram(\Yii::$app->modules['telegram']->API_KEY, \Yii::$app->modules['telegram']->BOT_NAME);
        $data = [];

        $session = \Yii::$app->session;
        if(!$session->has('tlgrm_chat_id')){
            throw new UserException('Unknown tlgrm_chat_id');
        }
        $tlgrmChatId = $session->get('tlgrm_chat_id');
        $data['text'] = htmlentities($message['message']);
        //сохраняем сообщение в БД
        $isSaved = false;
        try {
            $message = new Message();
            $message->client_chat_id = $tlgrmChatId;
            $message->message = $data['text'];
            $message->direction = 0;
            $message->time = date("Y-m-d H:i:s", time());
            $isSaved = $message->save();
        } catch (\Exception $e){
            var_dump('error saving to db');
            //continue anyway
        }
        //проверяем ведется ли уже диалог
        if ($isSaved) {
            $handledChat = AuthorizedManagerChat::find()->where(['client_chat_id' => $session->get('tlgrm_chat_id')])->one();
            if ($handledChat) {
                $data['chat_id'] = $handledChat->chat_id;
                Request::sendMessage($data);
                return $message;
            }
            //delete old chat handlers (who forgot execute /leavedialog)
            try {
                $timeBeforeResetChatHandler =  intval(\Yii::$app->modules['telegram']->timeBeforeResetChatHandler);
                if ($timeBeforeResetChatHandler > 0) {
                    AuthorizedManagerChat::updateAll(['client_chat_id' => null], ['<', 'timestamp', 'now() - 60 * ' . $timeBeforeResetChatHandler]);
                }
            }catch (\Exception $e){
                var_dump($e->getMessage());
            }
            //если нет то шлем всем свободным
            $authChats = AuthorizedManagerChat::find()->where(['client_chat_id' => null])->all();
            if (empty($authChats)) {
                $waitMessage = new Message();
                $waitMessage->client_chat_id = $tlgrmChatId;
                $waitMessage->message = Yii::t('tlgrm', 'At the moment, there are no available operators. Please, try to write later.');
                $waitMessage->direction = 1;
                $waitMessage->time = date("Y-m-d H:i:s", time() + 1);
                $waitMessage->save();
                return $message; //нет свободных
            }
            try{
                $yiiUsername = Yii::$app->getUser()->getIdentity()->username;
            } catch (\Exception $e){
                $yiiUsername = 'guest';
            }
            $data['text'] = $yiiUsername . Yii::t('tlgrm', " writes:") . "\r\n>" . $data['text'];
            foreach ($authChats as $authChat) {
                $data['chat_id'] = $authChat->chat_id;
                $inline_keyboard = [
                    new InlineKeyboardButton(['text' => Yii::t('tlgrm', 'Start conversation'), 'callback_data' => 'client_chat_id ' . $tlgrmChatId]),
                ];
                $data['reply_markup'] = new InlineKeyboardMarkup(
                    ['inline_keyboard' => [$inline_keyboard]]);
                Request::sendMessage($data);
            }
        }
        return $message;
    }
}
