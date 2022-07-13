<?php
use console\migrations\migrationMenu;
class m220712_040905_add_item_menu extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      // migrationMenu::insertOption('Comercial', null,null,'money');
        migrationMenu::insertOption('Comprobantes', '/com/com/index-invoices-simple','Comercial','arrow-right');
       migrationMenu::insertOption('Ventas', '/com/com/index-cashes','Comercial','money');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         migrationMenu::deleteOption('Comprobantes', '/com/com/index-invoices-simple','Comercial','arrow-right');
        migrationMenu::deleteOption('Ventas', '/com/com/index-cashes','Comercial','money');
       
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
