<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_cargoscoti}}`.
 */
class m230119_141531_create_table_cargoscoti_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_cargos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'descripcion'=>$this->string(40)->append($this->collateColumn()), 
            'porcentaje'=>$this->decimal(5,2), 
            'detalle'=>$this->text()->append($this->collateColumn()), 
            //'subtotal'=>$this->decimal(9,3), 
        ], $this->collateTable());
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
