<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%alterclipro}}`.
 */
class m220722_131836_create_alterclipro_table extends baseMigration
{
    
    const TABLE='{{%clipro}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'alias')){         
           $this->addColumn($table, 'alias', $this->string(30));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'alias')){         
           $this->dropColumn($table, 'alias');
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
