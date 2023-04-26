<?php

use yii\db\Migration;

/**
 * Class m230425_001115_alter_table_transacc
 */
class m230425_001115_alter_table_transacc extends console\migrations\baseMigration
{
   
    public $table='{{%transacciones}}';
    public $campo='afecta_reserva';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(1)); 
        }
        $this->campo='afecta_precio';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(1)); 
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->campo='afecta_precio';
        
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        $this->campo='afecta_reserva';
        
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
        
    }
}
    