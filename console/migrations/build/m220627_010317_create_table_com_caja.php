<?php

use console\migrations\baseMigration;

/**
 * Class m220627_010317_create_table_com_caja
 */
class m220627_010317_create_table_com_caja extends baseMigration
{
    public $table='{{%com_cajaventa}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codcaja'=>$this->char(4)->append($this->collateColumn()),
            'nombre'=>$this->string(12)->append($this->collateColumn()),
            'codcen'=>$this->string(5)->append($this->collateColumn()),
             'codsoc'=>$this->char(1)->append($this->collateColumn()),
            'path_impresora'=>$this->string(100)->append($this->collateColumn()),
             'user_id'=>$this->integer(4),
            ],$this->collateTable());
     
      }
        $this->paramsFk=[
                    $this->table,
                    'codcen',
                    '{{%centros}}',
                    'codcen'
                    ];
       $this->addFk();
       
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
