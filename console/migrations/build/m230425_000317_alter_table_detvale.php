<?php

use yii\db\Migration;

/**
 * Class m230425_000317_alter_table_detvale
 */
class m230425_000317_alter_table_detvale extends console\migrations\baseMigration
{
   
    public $table='{{%mat_detvale}}';
    public $campo='punit';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->decimal(10,3)); 
        }
        $this->campo='codal';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(4)); 
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->campo='codal';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       $this->campo='punit';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
    }
}
    