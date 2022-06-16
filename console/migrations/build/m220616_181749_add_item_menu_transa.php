<?php

use console\migrations\migrationMenu;

/**
 * Class m220616_181749_add_item_menu_transa
 */
class m220616_181749_add_item_menu_transa extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       //migrationMenu::insertOption('Herramientas', null,null,'wrench');
        migrationMenu::insertOption('Transacciones', '/masters/transa/index','Config','arrow-right');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       // migrationMenu::deleteOption('Importación', '/import/importacion/index','Herramientas');
        migrationMenu::deleteOption('Transacciones', '/masters/transa/index','Config');
        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220611_181945_add_item_masters_menu cannot be reverted.\n";

        return false;
    }
    */
}
