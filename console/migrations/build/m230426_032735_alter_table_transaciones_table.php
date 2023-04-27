<?php

use yii\db\Migration;

/**
 * Class m230426_032735_alter_table_transaciones_table
 */
class m230426_032735_alter_table_transaciones_table extends console\migrations\baseMigration
{
   
    public $table='{{%transacciones}}';
    public $campo='inversa_id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(4)); 
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
    