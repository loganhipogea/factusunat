<?php
namespace common\tlbot\types;

use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object represents a point on the map.
 */
class Location extends Type
{
    public $longitude;

    public $latitude;
}