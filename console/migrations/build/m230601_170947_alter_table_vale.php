<?php

class m230601_170947_alter_table_vale extends \console\migrations\baseMigration
{ 
    public $table='{{%mat_vale}}';
    public $campo='codcen';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(4)); 
        }
        $this->table='{{%op_os}}';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(4)); 
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
       $this->table='{{%op_os}}';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
    }
}