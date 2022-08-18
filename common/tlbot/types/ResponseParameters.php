<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * Contains information about why a request was unsuccessful.
 */
class ResponseParameters extends Type
{
    public $migrate_to_chat_id;

    public $retry_after;
}