<?php

use console\migrations\baseMigration;

/**
 * Class m230124_130907_add_columnresumen_detcoti
 */
class m230124_130907_add_columnresumen_detcoti extends baseMigration
{ public $table='{{%com_detcoti}}';
    public $campo='resumen';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
        
    }
       
} 