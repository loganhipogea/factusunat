<?php

use yii\db\Migration;

/**
 * Class m231125_134518_alter_table_detgui
 */
class m231125_134518_alter_table_detgui extends \console\migrations\baseMigration
{
    public $table='{{%mat_detguia}}';
    public $campo='rotativo';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(1)); 
        }
        
        $this->campo='activo';
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
       
       $this->campo='activo';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       
    }

    
}
