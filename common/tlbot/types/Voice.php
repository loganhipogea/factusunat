<?php
namespace common\tlbot\types;

use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents a voice note.
 */
class Voice extends Type
{
    public $file_id;

    public $file_unique_id;

    public $duration;

    public $mime_type;

    public $file_size;
}