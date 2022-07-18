<?php


use console\migrations\migrationMenu;

/**
 * Class m220627_023649_add_item_menu
 */
class m220715_140955_additemmenusunat extends migrationMenu
{
    public function safeUp()
    {
       migrationMenu::insertOption('SUNAT', null,null,'crosshairs');
       
       migrationMenu::insertOption('Config', '/sunat/default/config','SUNAT','cog');
       migrationMenu::insertOption('Usuarios', '/config/default/settings-module','SUNAT','users');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Config', '/sunat/default/config','SUNAT','cog');
       
        migrationMenu::deleteOption('SUNAT', null,null,'crosshairs');
         migrationMenu::insertOption('Usuarios', '/config/default/settings-module','SUNAT');
    }

}
