<?php

use console\migrations\baseMigration;

/**
 * Class m220722_133617_alter_matdetreq_table
 */
class m220722_133617_alter_matdetreq_table extends baseMigration
{ 
    const TABLE='{{%mat_detreq}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'user_id')){         
           $this->addColumn($table, 'user_id', $this->integer(5));
        }
        if(!$this->existsColumn($table,'fechaprog')){         
           $this->addColumn($table, 'fechaprog', $this->char(10));
        }
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
       
        
        if($this->existsColumn($table,'user_id')){         
           $this->dropColumn($table, 'user_id');
        }
         if($this->existsColumn($table,'fechaprog')){         
           $this->dropColumn($table, 'fechaprog');
        }
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
