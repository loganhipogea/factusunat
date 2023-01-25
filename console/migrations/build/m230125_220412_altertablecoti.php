<?php

use console\migrations\baseMigration;

/**
 * Class m230125_220412_altertablecoti
 */
class m230125_220412_altertablecoti extends baseMigration
{
    public $table='{{%com_cotizaciones}}';
    public $campo='version';/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(5,2));
        } 
       $this->campo='filtro';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->char(1));
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
       $this->campo='filtro';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
    }

   
}
