<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represent a user's profile pictures.
 */
class UserProfilePhotos extends Type
{
    public $total_count;

    public $photos;
}