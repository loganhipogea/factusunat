<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%costos}}`.
 */
class m230601_133600_create_costos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%cc_costos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),           
           // 'numero'=>$this->string(10)->append($this->collateColumn()),
            //'codestado'=>$this->char(2)->append($this->collateColumn()),
            'fecha'=>$this->char(10)->append($this->collateColumn()),
            
            'codocu'=>$this->char(4)->append($this->collateColumn()),
            'numdoc'=>$this->string(20)->append($this->collateColumn()),  
            'iddocu'=>$this->integer(11),
                
             'codocuref'=>$this->char(4)->append($this->collateColumn()),
            'numdocref'=>$this->string(20)->append($this->collateColumn()),  
            'iddocuref'=>$this->integer(11), 
                
            'tipo'=>$this->char(1)->append($this->collateColumn()),
            
           // 'fefin'=>$this->char(10)->append($this->collateColumn()),
            //'fprogini'=>$this->char(10)->append($this->collateColumn()), 
            //'fprofin'=>$this->char(10)->append($this->collateColumn()),    
            //'codpro'=>$this->char(10)->append($this->collateColumn()),
             'descripcion'=>$this->string(60)->append($this->collateColumn()),
            //'detalle'=>$this->text()->append($this->collateColumn()), 
               'codcen'=>$this->char(4)->append($this->collateColumn()), 
            // 'codocu'=>$this->char(4)->append($this->collateColumn()),
             'monto'=>$this->decimal(12,3),
             'user_id'=>$this->integer(11),
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
