<?php

use console\migrations\migrationMenu;

/**
 * Class m220616_174814_add_item_menu_tools_import
 */
class m220616_174814_add_item_menu_tools_import extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       migrationMenu::insertOption('Herramientas', null,null,'wrench');
        migrationMenu::insertOption('Importación', '/import/importacion/index','Herramientas','arrow-right');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Importación', '/import/importacion/index','Herramientas');
        migrationMenu::deleteOption('Herramientas', null,null,'wrench');
        
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
