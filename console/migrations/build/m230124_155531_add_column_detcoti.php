<?php

use console\migrations\baseMigration;

/**
 * Class m230124_155531_add_column_detcoti
 */
class m230124_155531_add_column_detcoti extends baseMigration
{public $table='{{%com_detcoti}}';
    public $campo='mostrar';
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