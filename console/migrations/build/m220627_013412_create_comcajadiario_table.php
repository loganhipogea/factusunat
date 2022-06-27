<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%comcajadiario}}`.
 */
class m220627_013412_create_comcajadiario_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_cajadia}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'caja_id'=>$this->integer(11),
             'fecha'=>$this->char(10)->append($this->collateColumn()),
             'monto_papel'=>$this->decimal(9,2),
             'monto_efectivo'=>$this->decimal(9,2),
              'diferencia'=>$this->decimal(9,2), 
             'estado'=>$this->char(1),
             
        ],$this->collateTable());
        $this->paramsFk=[
            $this->table,
            'caja_id',
            '{{%com_cajaventa}}',
            'id'
        ];
        $this->addFk();
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
