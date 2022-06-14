<?php

use console\migrations\migrationMenu;

/**
 * Class m220614_213549_add_item_menu
 */
class m220614_213549_add_item_menu extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

      migrationMenu::insertOption('Config', null,null);
        migrationMenu::insertOption('Parámetros', '/settings/index','Maestros');
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         migrationMenu::deleteOption('Parámetros', '/settings/index','Maestros');
        migrationMenu::deleteOption('Config', null,null);
        
    }
    
}
