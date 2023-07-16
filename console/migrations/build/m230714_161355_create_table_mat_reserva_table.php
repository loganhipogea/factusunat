<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_mat_reserva}}`.
 */
class m230714_161355_create_table_mat_reserva_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%mat_reserva}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
             $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'fecha'=>$this->string(10)->append($this->collateColumn()), 
            'numero'=>$this->string(14)->append($this->collateColumn()), 
               'detalle'=>$this->text()->append($this->collateColumn()),     
          'codocuref'=>$this->char(3)->append($this->collateColumn()), 
              'numdocref'=>$this->string(20)->append($this->collateColumn()), 
               
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
