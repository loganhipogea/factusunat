<?php
use console\migrations\migrationMenu;
class m220627_150630_add_item_menu_materiales extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      //migrationMenu::insertOption('Maestros', null,null,'dr');
        migrationMenu::insertOption('Materiales', '/masters/materials','Maestros','arrow-right');
      // migrationMenu::insertOption('Facturación', '/com/com/index-invoices','Comercial','money');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       migrationMenu::dropOption('Materiales', '/masters/materials','Maestros','arrow-right');
        
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
