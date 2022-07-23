<?php

use console\migrations\baseMigration;

/**
 * Class m220722_132437_alter_contactos_table
 */
class m220722_132437_alter_contactos_table extends baseMigration
{
  const TABLE='{{%contactos}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'detalle')){         
           $this->addColumn($table, 'detalle', $this->text());
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'detalle')){         
           $this->dropColumn($table, 'detalle');
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
