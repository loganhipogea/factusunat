<?php
use console\migrations\baseMigration;
class m220629_234808_add_column_comfactu extends baseMigration
{
    public $table='{{%com_factura}}';
    public $campo='total';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
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
