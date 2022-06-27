<?php
use console\migrations\baseMigration;
class m220626_013608_alter_ovdet_table extends baseMigration
{
    public $table='{{%com_ovdet}}';
    public $campo='activo';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
        
     
   }
}
