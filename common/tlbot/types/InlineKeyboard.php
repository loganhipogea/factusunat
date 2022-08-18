<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents an inline keyboard that appears right next to the message it belongs to.
 */
class InlineKeyboard extends Type
{
    public $text;
    
    public $callback_data;

    public $url;
    
}