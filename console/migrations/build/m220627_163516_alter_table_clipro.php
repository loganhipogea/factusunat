<?php
use console\migrations\baseMigration;
class m220627_163516_alter_table_clipro extends baseMigration
{
    public $table='{{%clipro}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'codsoc')){  
            $this->addColumn($this->table, 'codsoc', $this->char(1));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'codsoc')){  
            $this->dropColumn($this->table, 'codsoc');
        }
       
   }
}
