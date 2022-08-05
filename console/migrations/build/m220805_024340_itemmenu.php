<?php
use console\migrations\baseMigration;
use console\migrations\migrationMenu;
class m220805_024340_itemmenu extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    { 
        
        //migrationMenu::insertOption('Contabilidad', null,null,'balance-scale');
    migrationMenu::insertOption('Ordenes', '/cc/ceco/index-orden','Contabilidad','list');
    migrationMenu::insertOption('Documentos', '/documentos/index','Maestros','list');
    migrationMenu::insertOption('Sociedades', '/site/index-companies','Maestros','factory');
    migrationMenu::insertOption('Bancos', '/masters/basico/bancos','Maestros','build');
         
           
         
         
           

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     migrationMenu::deleteOption('Ordenes', '/cc/ceco/index-orden','Contabilidad');
    migrationMenu::deleteOption('Documentos', '/documentos/index','Maestros');
    migrationMenu::deleteOption('Sociedades', '/site/index-companies','Maestros');
    migrationMenu::deleteOption('Bancos', '/masters/basico/bancos','Maestros');
         
         
   
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220805_024340_itemmenu cannot be reverted.\n";

        return false;
    }
    */
}
