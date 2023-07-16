<?php

use yii\db\Migration;

/**
 * Class m230714_140005_alter_table_mat_vale
 */
class m230714_140005_alter_table_mat_vale extends console\migrations\baseMigration
{ 
    public $table='{{%mat_vale}}';
    public $campo='codmon';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->string(3)); 
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