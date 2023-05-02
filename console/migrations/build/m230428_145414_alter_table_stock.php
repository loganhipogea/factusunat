<?php

use yii\db\Migration;

/**
 * Class m230428_145414_alter_table_stock
 */
class m230428_145414_alter_table_stock extends console\migrations\baseMigration
{
   
    public $table='{{%mat_stock}}';
    public $campo='abc';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
        
        
    }
}
    