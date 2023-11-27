<?php

use console\migrations\baseMigration;

/**
 * Class m231127_033551_alter_transacciones_table
 */
class m231127_033551_alter_transacciones_table extends baseMigration
{
   public $table='{{%transacciones}}';
    public $campo='compromete_proveedor';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(1)); 
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
