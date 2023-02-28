<?php

use console\migrations\baseMigration;

/**
 * Class m230228_180908_alter_tables_descripciones
 */
class m230228_180908_alter_tables_descripciones  extends baseMigration
{
    public $table='{{%com_cotigrupos}}';
    public $campo='descripartida';/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      if(!$this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo,$this->string(80)->append($this->collateColumn())); 
        } 
       
       $this->table='{{%com_cotizaciones}}';
       $this->campo='descripcion';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo, $this->string(80)->append($this->collateColumn())); 
        } 
      
       $this->table='{{%com_detcoti}}';
       $this->campo='descripcion';
     
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo, $this->string(80)->append($this->collateColumn())); 
        } 
        
       
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo,$this->string(40)->append($this->collateColumn())); 
        } 
       
       $this->table='{{%com_cotizaciones}}';
       $this->campo='descripcion';
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo, $this->string(40)->append($this->collateColumn())); 
        } 
      
       $this->table='{{%com_detcoti}}';
       $this->campo='descripcion';
    
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->alterColumn($this->table,$this->campo, $this->string(40)->append($this->collateColumn())); 
        } 
    }     
   
}
