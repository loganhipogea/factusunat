<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * 
 */
class Entities extends Type
{
    public $entities = [];

    public function __construct($config)
    {
        foreach($config as $attribute)
        {
            $this->entities[] = new Entitie($attribute);
        }
    }

}