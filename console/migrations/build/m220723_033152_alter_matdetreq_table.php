<?php

use console\migrations\baseMigration;

/**
 * Class m220723_033152_alter_matdetreq_table
 */
class m220723_033152_alter_matdetreq_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
   const TABLE='{{%mat_detreq}}';
     public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'tipo')){         
           $this->addColumn($table, 'tipo', $this->char(3));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'tipo')){         
           $this->dropColumn($table, 'tipo');
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
