<?php


use console\migrations\migrationMenu;

/**
 * Class m220627_023649_add_item_menu
 */
class m220627_023649_add_item_menu extends migrationMenu
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       migrationMenu::insertOption('Comercial', null,null,'money');
        migrationMenu::insertOption('Pto venta', '/com/com/crea-ov-plus','Comercial','arrow-right');
       migrationMenu::insertOption('Facturación', '/com/com/index-invoices','Comercial','money');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         migrationMenu::deleteOption('Facturación', '/com/com/index-invoices','Comercial','money');
        migrationMenu::deleteOption('Pto venta', '/com/com/crea-ov-plus','Comercial','arrow-right');
        migrationMenu::deleteOption('Comercial', null,null,'money');
        
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
