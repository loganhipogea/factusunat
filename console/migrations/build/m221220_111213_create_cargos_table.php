<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%cargos}}`.
 */
class m221220_111213_create_cargos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%cargos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'descricargo'=> $this->string(40)->append($this->collateColumn()), 
            'codcargo'=> $this->string(6)->append($this->collateColumn()),  
            'hh'=> $this->decimal(6,2),    
        ]);
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
