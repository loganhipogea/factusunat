<?php
use console\migrations\baseMigration;

/**
 * Class m220628_023740_alter_table_factura
 */
class m220628_023740_alter_table_factura extends baseMigration
{
    public $table='{{%com_factura}}';
    public $campo='sunat_totgrav';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        $this->campo='sunat_totexo';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        $this->campo='sunat_totigv';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        $this->campo='sunat_totimpuestos';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        $this->campo='descuento';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        $this->campo='subtotal';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        $this->campo='sunat_totisc';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
        $this->campo='totalventa';
        if(!$this->existsColumn($this->table,$this->campo)){  
           $this->addColumn($this->table,$this->campo, $this->decimal(12,2));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->campo='sunat_totgrav';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='sunat_totexo';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='sunat_totigv';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='sunat_totimpuestos';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='descuento';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='subtotal';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='sunat_totisc';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        $this->campo='totalventa';
        if($this->existsColumn($this->table,$this->campo)){  
           $this->dropColumn($this->table,$this->campo);
        }
        
     
   }
}
