<?php

use console\migrations\baseMigration;

/**
 * Class m230906_010555_alter_table_matdetreq
 */
class m230906_010555_alter_table_matdetreq extends baseMigration
{
    public $table='{{%mat_detreq}}';
    public $campo='codpro';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->string(10)); 
        }
        $this->campo='servicio_id';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->integer(11)); 
        }
        
         $this->campo='codest';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(2)); 
        }
        
          $this->campo='ceco_id';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->integer(11)); 
        }
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
         $this->campo='ceco_id';
        
          if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
         $this->campo='servicio_id';
        
          if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       
       $this->campo='codpro';
        
          if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       
       $this->campo='codest';
        
          if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
    }

    
}
