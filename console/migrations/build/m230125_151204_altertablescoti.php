<?php

use console\migrations\baseMigration;

/**
 * Class m230125_151204_altertablescoti
 */
class m230125_151204_altertablescoti extends baseMigration
{
    public $table='{{%com_cotigrupos}}';
    public $campo='montoneto';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(6));
        }    
        
        $this->table='{{%com_detcoti}}';
        //$this->campo='orden';
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
       $this->table='{{%com_detcoti}}';
        //$this->campo='orden';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
    }
       
} 