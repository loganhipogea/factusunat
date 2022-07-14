<?php

use console\migrations\baseMigration;

class m220713_223512_create_comseries_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_series_factura}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'serie'=>$this->string(10)->append($this->collateColumn()),
            'codcen'=>$this->string(5)->append($this->collateColumn()),
            'tipodoc'=>$this->char(2)->append($this->collateColumn()),    
                
        ],$this->collateTable());
      }
    }
      
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
