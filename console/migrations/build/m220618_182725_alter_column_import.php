<?php

use console\migrations\baseMigration;

/**
 * Class m220618_182725_alter_column_import
 */
class m220618_182725_alter_column_import extends baseMigration
{
    public $table='{{%import_carga_user}}';
    public function safeUp()
    {
        if($this->existsColumn($this->table, 'fechacarga'))
        $this->alterColumn($this->table,'fechacarga',$this->char(19));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220618_182725_alter_column_import cannot be reverted.\n";

        return false;
    }
    */
}
