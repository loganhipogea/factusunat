<?php

namespace common\tlbot\types\inputMedia;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents a chat.
 */
class sendMediaGroup extends Type
{
    public $chat_id;

    /**
     * @var Array of InputMediaAudio, InputMediaDocument, InputMediaPhoto and InputMediaVideo
     */
    public $media;
    
    public $disable_notification;

    public $reply_to_message_id;

    public $allow_sending_without_reply;
}
