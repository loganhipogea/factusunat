<?php

use console\migrations\baseMigration;

/**
 * Class m230925_025341_alter_table_mat_detvale_table
 */
class m230925_025341_alter_table_mat_detvale_table extends baseMigration
{
    public $table='{{%mat_detvale}}';
    public $campo='detres_id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->integer(11)); 
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
