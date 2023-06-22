<?php

use console\migrations\baseMigration;

/**
 * Class m230622_004745_alter_table_coti_versiones
 */
class m230622_004745_alter_table_coti_versiones extends baseMigration
{
    
    public $table='{{%com_cotiversiones}}';
    public $campo='fakecoti_id';
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