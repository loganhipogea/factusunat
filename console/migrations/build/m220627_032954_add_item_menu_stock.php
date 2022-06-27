<?php
use console\migrations\migrationMenu;
class m220627_032954_add_item_menu_stock extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      migrationMenu::insertOption('Logística', null,null,'truck');
        migrationMenu::insertOption('Stock', '/logi/stock','Logística','arrow-right');
      // migrationMenu::insertOption('Facturación', '/com/com/index-invoices','Comercial','money');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Stock', '/logi/stock','Logística','arrow-right');
        //migrationMenu::deleteOption('Pto venta', '/com/com/crea-ov-plus','Comercial','arrow-right');
        migrationMenu::deleteOption('Logística', null,null,'truck');
        
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
