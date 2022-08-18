<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\longman\TelegramBot\Commands\SystemCommands;

use common\onmotion\telegram\models\AuthorizedManagerChat;
use common\onmotion\telegram\models\Usernames;
use common\longman\TelegramBot\Commands\SystemCommand;
use common\longman\TelegramBot\Request;
use Yii;

/**
 * Callback query command
 */
class CallbackqueryCommand extends SystemCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'callbackquery';
    protected $description = 'Reply to callback query';
    protected $version = '1.0.0';
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        //Do nothing, just for rewriting default Longman command
        return Request::emptyResponse();
    }
}
