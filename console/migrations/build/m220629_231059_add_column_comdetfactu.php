<?php
use console\migrations\baseMigration;
class m220629_231059_add_column_comdetfactu extends baseMigration
{
    public $table='{{%com_factudet}}';
    public $campo='punitgravado';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
        }
        $this->campo='pventa';
         if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
        }
        $this->campo='totimpuesto';
         if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
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
        $this->campo='pventa';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
        }
        $this->campo='totimpuesto';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(10,2));
        }
   }
}
