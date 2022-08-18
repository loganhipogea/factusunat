<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * 
 */
class Photo extends Type
{
    public $photoSize = [];

    public function __construct($config)
    {
        foreach($config as $attribute)
        {
            $this->photoSize[] = new PhotoSize($attribute);
        }
    }

}