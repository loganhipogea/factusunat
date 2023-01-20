<?php
USE console\migrations\migrationMenu;

/**
 * Class m230119_162533_create_menu_cargoscoti
 */
class m230119_162533_create_menu_cargoscoti extends migrationMenu
{
    public function safeUp()
    {
        migrationMenu::insertOption('Cargos', '/com/coticargos/index-cargos','Comercial','cubes');
    }
    
    public function safeDown()
    {
         migrationMenu::deleteOption('Cargos', '/com/coticargos/index-cargos','Comercial','cubes');
    }
    
}