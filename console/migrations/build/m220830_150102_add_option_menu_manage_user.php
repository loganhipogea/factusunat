<?php
USE console\migrations\migrationMenu;
class m220830_150102_add_option_menu_manage_user extends console\migrations\baseMigration
{  
    public function safeUp()
    {
        migrationMenu::insertOption('Gestionar usuarios', '/profile/manage-users','User','users');
        migrationMenu::insertOption('Movimientos', '/cc/cuentas/index-mov','Contabilidad','coins'); 
    }
    
    public function safeDown()
    {
         migrationMenu::deleteOption('Movimientos', '/cc/cuentas/index-mov','Contabilidad','coins');
         migrationMenu::deleteOption('Gestionar usuarios', '/profile/manage-users','User','users');
    }

}
