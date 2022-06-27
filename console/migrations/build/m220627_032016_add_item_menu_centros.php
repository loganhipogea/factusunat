<?php
use console\migrations\migrationMenu;
class m220627_032016_add_item_menu_centros extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      
        migrationMenu::insertOption('Centros', '/masters/centros','Maestros','arrow-right');
      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Centros', null,null,'arrow-right');
        
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
