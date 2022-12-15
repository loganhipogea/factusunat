<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%compartidas}}`.
 */
class m221130_012127_create_compartidas_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_cotigrupos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'descripartida'=>$this->string(40)->append($this->collateColumn()), 
            'calificacion'=>$this->char(1)->append($this->collateColumn()),
            
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
