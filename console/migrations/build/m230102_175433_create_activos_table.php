<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%activos}}`.
 */
class m230102_175433_create_activos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%mat_activos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
$this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codigo'=>$this->string(10)->append($this->collateColumn()), 
            'descripcion'=>$this->string(50)->append($this->collateColumn()),
            'marca'=>$this->string(50)->append($this->collateColumn()), 
            'modelo'=>$this->string(50)->append($this->collateColumn()), 
            'serie'=>$this->string(50)->append($this->collateColumn()), 
            'v_adquisicion'=>$this->decimal(9,3),
            'vida_util'=>$this->integer(3),
            'v_rescate'=>$this->decimal(9,3), 
            'parent_id'=>$this->integer(11),
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
