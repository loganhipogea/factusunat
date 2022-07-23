<?php

use console\migrations\baseMigration;

/**
 * Class m220722_132903_alter_matdetvale_table
 */
class m220722_132903_alter_matdetvale_table extends baseMigration
{
    
    const TABLE='{{%mat_detvale}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'detreq_id')){         
           $this->addColumn($table, 'detreq_id', $this->integer(11));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'detreq_id')){         
           $this->dropColumn($table, 'detreq_id');
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
