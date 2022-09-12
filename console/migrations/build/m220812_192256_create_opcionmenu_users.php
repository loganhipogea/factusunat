<?php

use yii\db\Migration;
USE console\migrations\migrationMenu;
/**
 * Class m220812_192256_create_opcionmenu_users
 */
class m220812_192256_create_opcionmenu_users extends \console\migrations\baseMigration
{

    public function safeUp()
    {
        migrationMenu::insertOption('Gestionar usuarios', '/profile/manage-users','User','users');
         
    }

    
    public function safeDown()
    {
         migrationMenu::deleteOption('Gestionar usuarios', '/profile/manage-users','User');
         
    }

}
