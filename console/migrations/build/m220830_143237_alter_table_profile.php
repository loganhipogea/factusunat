<?php

class m220830_143237_alter_table_profile extends console\migrations\baseMigration
{
   public $table='{{%profile}}';
    public $campo='hash';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(10));
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
