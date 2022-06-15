<?php
use console\migrations\migrationMenu;
class m220615_174206_add_item_menu_combo_masters extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    
        migrationMenu::insertOption('Desplegables', '/masters/combo','Config','');
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         migrationMenu::deleteOption('Desplegables',  '/masters/combo','Config','');
       
        
    }
    
}
