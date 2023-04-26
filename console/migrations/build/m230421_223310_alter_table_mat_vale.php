<?php

use yii\db\Migration;

/**
 * Class m230421_223310_alter_table_mat_vale
 */
class m230421_223310_alter_table_mat_vale extends console\migrations\baseMigration
{
   
    public $table='{{%mat_vale}}';
    public $campo='codocu';/**
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(3)->append($this->collateColumn())); 
        }
        $this->campo='numerodoc';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->string(40)->append($this->collateColumn())); 
        }
        
        $this->campo='fechacon';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(10)->append($this->collateColumn())); 
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->campo='fechacon';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
         $this->campo='numerodoc';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       
         $this->campo='codocu';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
    }
}
    
   
