<?php

use console\migrations\baseMigration;
class m220708_134217_altercolum_cajadia_estado extends baseMigration
{
     public $table='{{%com_cajadia}}';
     public $campo='estado';
    public function safeUp()
    {
        if($this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo, $this->char(2));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo, $this->char(1));
        }
     
   }
}
