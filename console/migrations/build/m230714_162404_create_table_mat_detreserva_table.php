<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_mat_detreserva}}`.
 */
class m230714_162404_create_table_mat_detreserva_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%mat_reservadet}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
$this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'reserva_id'=>$this->integer(),
            'stock_id'=>$this->integer(),
             'item'=>$this->char(4)->append($this->collateColumn()),
             'fecha'=>$this->string(19)->append($this->collateColumn()),
            'cant'=>$this->decimal(8,3), 
              'codestado'=>$this->char(1)->append($this->collateColumn()), 
              'detalle'=>$this->string(20)->append($this->collateColumn()),  
             
                 
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
