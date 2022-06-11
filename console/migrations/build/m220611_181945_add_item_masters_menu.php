<?php
use console\migrations\baseMigration;
use console\migrations\migrationMenu;
/**
 * Class m220611_181945_add_item_masters_menu
 */
class m220611_181945_add_item_masters_menu extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       migrationMenu::insertOption('Maestros', null,null);
        migrationMenu::insertOption('Empresas', '/masters/clipro','Maestros');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Empresas', '/masters/clipro','Maestros');
        migrationMenu::deleteOption('Maestros', null,null);
        
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
