<?php

use console\migrations\baseMigration;

/**
 * Class m220913_160148_mat_petoferta_table
 */
class m220913_160148_mat_petoferta_table extends baseMigration
{ 
    public $table='{{%mat_petoferta}}';
    
    public function safeUp(){
   if(!$this->existsTable($this->table)) {
         $this->createTable($this->table, [
             'id' => $this->primaryKey(),
             'numero'=>$this->string(10)->append($this->collateColumn()),
              'codcen'=>$this->string(5)->append($this->collateColumn()),
             'codsoc'=>$this->char(1)->append($this->collateColumn()),
              'codpro'=>$this->char(10)->append($this->collateColumn()),
             'fecha'=>$this->char(10)->append($this->collateColumn()),
             'codtra'=>$this->char(6)->append($this->collateColumn()),
              'codmon'=>$this->char(3)->append($this->collateColumn()),
             'user_id'=>$this->integer(11),
             'estado'=>$this->char(2)->append($this->collateColumn()),
             'descripcion'=>$this->string(40)->append($this->collateColumn()),
             'detalle'=>$this->text()->append($this->collateColumn()),
            
        ],$this->collateTable());
         
       
         $this->paramsFk=[
            $this->table,
            'codcen',
            '{{%centros}}',
            'codcen'
                ];
           $this->addFk(); 
           
          $this->paramsFk=[
            $this->table,
            'codtra',
            '{{%trabajadores}}',
            'codigotra'
                ];
           $this->addFk(); 
           
           $this->paramsFk=[
            $this->table,
            'codpro',
            '{{%clipro}}',
            'codpro'
                ];
           $this->addFk(); 
      }
    }
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
