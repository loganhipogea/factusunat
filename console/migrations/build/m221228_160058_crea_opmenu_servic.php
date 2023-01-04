<?php


USE console\migrations\migrationMenu;
/**
 * Class m221228_160058_crea_opmenu_servic
 */
class m221228_160058_crea_opmenu_servic  extends console\migrations\baseMigration
{  
    public function safeUp()
    {
        migrationMenu::insertOption('Servicios', '/masters/servicios','Maestros','cubes');
    }
    
    public function safeDown()
    {
         migrationMenu::deleteOption('Servicios', '/masters/servicios','Maestros','cubes');
    }

}
