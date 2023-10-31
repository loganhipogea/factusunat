<?php

use console\migrations\baseMigration;

/**
 * Class m230910_184414_alter_table_mat_req_table
 */
class m230910_184414_alter_table_mat_req_table extends baseMigration
{public $table='{{%mat_req}}';
    public $campo='auto';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->string(1)); 
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
