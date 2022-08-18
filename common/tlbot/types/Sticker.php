<?php

namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents a chat.
 */
class Sticker extends Type
{
    public $width;

    public $height;
    public $emoji;
    public $mask_position;
   public $file_size;
   public $set_name;
   
    public $is_animated;

    public $file_id;

    public $file_unique_id;
    
    

    private $_thumb;

    /**
     * 
     */
    public function getThumb()
    {
         return $this->_thumb;
    }

    /**
     * 
     */
    public function setThumb($value)
    {
         $this->_thumb = new Sticker($value);
    }
    
}
