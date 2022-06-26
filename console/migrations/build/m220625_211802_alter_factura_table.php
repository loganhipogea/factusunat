<?php
use console\migrations\baseMigration;

class m220625_211802_alter_factura_table extends baseMigration
{
     public $table='{{%com_factura}}';
     public $campo='serie';
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(4));
        }
        if(!$this->existsColumn($this->table,'codestado')){  
            $this->addColumn($this->table,'codestado', $this->char(2));
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
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,'codestado');
        }
     
   }
}
