<?php
use console\migrations\baseMigration;
use console\migrations\migrationMenu;
class m220611_200038_add_item_ums_menu  extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      // migrationMenu::insertOption('Maestros', null,null);
        migrationMenu::insertOption('Unidades medida', '/masters/ums/index','Maestros');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Unidades medida', '/masters/ums/index','Maestros');
       
        
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
