<?php

use console\migrations\baseMigration;

/**
 * Class m230925_044201_alter_table_mat_detreserva_table
 */
class m230925_044201_alter_table_mat_detreserva_table extends baseMigration
{
    public $table='{{%mat_reservadet}}';
    public $campo='valor_soles';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->decimal(10,3)); 
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
