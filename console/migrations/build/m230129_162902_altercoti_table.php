<?php

use console\migrations\baseMigration;

/**
 * Class m230129_162902_altercoti_table
 */
class m230129_162902_altercoti_table extends baseMigration
{
    public $table='{{%com_cotizaciones}}';
    public $campo='memoria';/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->text()->append($this->collateColumn())); 
        } 
       $this->campo='fpago';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->char(2)->append($this->collateColumn())); 
        } 
      
      $this->campo='sumaopunit';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->char(1)->append($this->collateColumn())); 
        } 
        
        $this->putCombo($this->table,'fpago',[
            '10'=>'FACTURA A 15 DIAS',
            '20'=>'FACTURA A 30 DIAS',
            '30'=>'FACTURA A 45 DIAS',
            '40'=>'FACTURA A 60 DIAS',
            '40'=>'FACTURA A 90 DIAS',
            ]);
        $this->putCombo($this->table,'sumaopunit',[
            'SUMA ALZADA',
            'PRECIOS UNITARIOS',
            ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        
        
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       $this->campo='fpago';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
          
       }
      $this->deleteCombo($table, $this->campo);
      $this->campo='sumaopunit';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       
       $this->deleteCombo($table, $this->campo);
      
    }

   
}
