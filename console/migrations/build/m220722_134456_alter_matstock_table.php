<?php

use console\migrations\baseMigration;

/**
 * Class m220722_134456_alter_matstock_table
 */
class m220722_134456_alter_matstock_table extends baseMigration
{
    
    const TABLE='{{%mat_stock}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'valor_unit')){         
           $this->addColumn($table, 'valor_unit', $this->decimal(10,2));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'valor_unit')){         
           $this->dropColumn($table, 'valor_unit');
        }
       
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M210601034325AlterTableMediaApps cannot be reverted.\n";

        return false;
    }
    */
}
