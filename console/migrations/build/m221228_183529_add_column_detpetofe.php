<?php
use console\migrations\baseMigration;
class m221228_183529_add_column_detpetofe extends baseMigration
{
    public $table='{{%mat_detpetoferta}}';
    public $campo='servicio_id';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
        $this->campo='flag';
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
       $this->campo='flag';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       } 
    }
       
} 