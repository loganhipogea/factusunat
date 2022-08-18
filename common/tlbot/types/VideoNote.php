<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents a video message (available in Telegram apps as of v.4.0).
 */
class VideoNote extends Type
{
    public $file_id;

    public $file_unique_id;

    public $length;

    public $duration;

    public $thumb;

    public $file_size;
}