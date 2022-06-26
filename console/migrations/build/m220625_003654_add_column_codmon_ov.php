<?php

use console\migrations\baseMigration;

/**
 * Class m220625_003654_add_column_codmon_ov
 */
class m220625_003654_add_column_codmon_ov extends baseMigration
{
    public $table='{{%com_ov}}';
    public $campo='codmon';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(4));
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
