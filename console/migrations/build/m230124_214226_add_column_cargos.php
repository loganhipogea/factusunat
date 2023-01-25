<?php
use console\migrations\baseMigration;
class m230124_214226_add_column_cargos extends baseMigration
{
   public $table='{{%com_cargos}}';
    public $campo='etiqueta';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(6));
        }    
        
        $this->table='{{%com_cargoscoti}}';
        $this->campo='orden';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(2));
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
       $this->table='{{%com_cargoscoti}}';
        $this->campo='orden';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
    }
       
} 