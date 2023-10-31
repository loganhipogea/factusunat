<?php
use console\migrations\baseMigration;

/**
 * Class m230927_021921_alter_table_op_tareo_table
 */
class m230927_021921_alter_table_op_tareo_table extends baseMigration
{ 
    public $table='{{%op_tareo}}';
    public $campo='os_id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->integer(11)); 
        }
        
        
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
          if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       
    }
}
