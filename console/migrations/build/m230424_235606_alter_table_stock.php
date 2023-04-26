<?php

use yii\db\Migration;

/**
 * Class m230424_235606_alter_table_stock
 */
class m230424_235606_alter_table_stock extends console\migrations\baseMigration
{
   
    public $table='{{%mat_stock}}';
    public $campo='cant_disp';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->decimal(8,3)); 
        }
        
        $this->campo='semaforo';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(1)); 
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
        $this->campo='semaforo';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
    }
}
    