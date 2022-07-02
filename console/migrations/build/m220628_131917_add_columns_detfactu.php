<?php
use console\migrations\baseMigration;
class m220628_131917_add_columns_detfactu extends baseMigration
{
    public $table='{{%com_factudet}}';
    public $campo='sunat_totgrav';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->campo='isc';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
        }
        $this->campo='descuento';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
        }
        $this->campo='gravado';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
        }
        $this->campo='exo';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->campo='isc';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='descuento';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='gravado';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
       $this->campo='exo';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
     
   }
}
