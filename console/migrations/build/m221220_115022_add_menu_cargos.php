<?php
USE console\migrations\migrationMenu;
class m221220_115022_add_menu_cargos  extends console\migrations\baseMigration
{  
    public function safeUp()
    {
        migrationMenu::insertOption('Cargos', '/masters/cargos','Maestros','users');
          }
    
    public function safeDown()
    {
         migrationMenu::deleteOption('Cargos', '/masters/cargos','Maestros','users');
    }

}
