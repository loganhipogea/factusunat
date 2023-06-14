<?php

use console\migrations\baseMigration;

/**
 * Class m230601_151055_alter_tables_con_codocus
 */
class m230601_151055_alter_tables_con_codocus extends baseMigration
{
    
    public $table='{{%mat_kardex}}';
    public $campo='codocu';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(3)); 
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