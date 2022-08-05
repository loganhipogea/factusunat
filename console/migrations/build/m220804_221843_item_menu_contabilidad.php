<?php
use console\migrations\baseMigration;
use console\migrations\migrationMenu;
use common\helpers\h;
class m220804_221843_item_menu_contabilidad extends baseMigration
{/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        migrationMenu::insertOption('Contabilidad', null,null,'balance-scale');
        migrationMenu::insertOption('Cuentas', '/cc/cuentas/index','Contabilidad','money');
         migrationMenu::insertOption('Colectores', '/cc/ceco/index','Contabilidad','tag');
         
         
         migrationMenu::insertOption('Tar Seman', '/op/tareo/index-tareo-semana','Operaciones','calendar');
         
           h::getIfNotPutSetting('cc','codocu_compensacion','100');
           h::getIfNotPutSetting('cc','codocu_compesacion_hereda','100');
           h::getIfNotPutSetting('cc','codocu_cargo_rendir','100');
           h::getIfNotPutSetting('cc','codocu_fondo_fijo','100');
            h::getIfNotPutSetting('cc','codocu_cargo_devolucion_efectivo','100');
           
           
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         migrationMenu::deleteOption('Tar Seman', '/op/tareo/index-tareo-semana','Operaciones');
          migrationMenu::deleteOption('Colectores', '/cc/ceco/index','Contabilidad');
          migrationMenu::deleteOption('Cuentas', '/cc/cuentas/index','Contabilidad');
         migrationMenu::deleteOption('Contabilidad', null,null);
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
