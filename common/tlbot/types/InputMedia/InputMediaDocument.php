<?php
namespace common\tlbot\types\inputMedia;

use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * Represents a general file to be sent.
 */
class InputMediaDocument extends Type implements InputMedia
{
    public $type;

    public $media;

    public $thumb;

    public $caption;

    public $parse_mode;
}