<?php

USE console\migrations\migrationMenu;

/**
 * Class m230104_141734_add_optionactivo
 */
class m230104_141734_add_optionactivo extends migrationMenu
{  
    public function safeUp()
    {
        migrationMenu::insertOption('Activos', '/mat/activos/index','Maestros','cubes');
    }
    
    public function safeDown()
    {
         migrationMenu::deleteOption('Activos', '/mat/activos/index','Maestros','cubes');
    }

}