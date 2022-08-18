<?php
namespace common\tlbot\types;

use common\tlbot\base\Type;
/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 */
class ReplyKeyboardMarkup extends Type
{
    public $keyboard;

    public $resize_keyboard;

    public $one_time_keyboard;

    public $selective;
}