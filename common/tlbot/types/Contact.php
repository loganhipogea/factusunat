<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents a phone contact.
 */
class Contact extends Type
{
    public $phone_number;

    public $first_name;

    public $last_name;

    public $user_id;

    public $vcard;
}