<?php

use console\migrations\migrationMenu;

/**
 * Class m220614_213549_add_item_menu
 */
class m220614_213549_add_item_menu_settings extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

      migrationMenu::insertOption('Config', null,null);
        migrationMenu::insertOption('Parametros', '/settings','Config');
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         migrationMenu::deleteOption('Parámetros', '/settings/index','Config');
        migrationMenu::deleteOption('Config', null,null);
        
    }
    
}
