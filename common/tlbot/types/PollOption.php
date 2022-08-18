<?php
namespace common\tlbot\types;


use common\tlbot\base\Type;

/**
 * @author Akbar Joudi <akbar.joody@gmail.com>
 * This object contains information about one answer option in a poll.
 */
class PollOption extends Type
{
    public $text;

    public $voter_count;
}