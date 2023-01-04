<?php
use console\migrations\baseMigration;
class m221228_224700_add_column_detcoti extends baseMigration
{
    public $table='{{%com_detcoti}}';
    public $campo='detcoti_id';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
        $this->campo='detcoti_id_id';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
        $this->campo='servicio_id';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
       $this->campo='flag';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->char(1));
        } 
       $this->campo='codcargo';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->char(6));
        } 
        $this->campo='codactivo';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->char(8));
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
        $this->campo='detcoti_id_id';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       } 
        $this->campo='servicio_id';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       } 
       
       
       $this->campo='flag';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       } 
       
       $this->campo='codcargo';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       } 
       
      $this->campo='codactivo';
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       } 
    }
       
} 