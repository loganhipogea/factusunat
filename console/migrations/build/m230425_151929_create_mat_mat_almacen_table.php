<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%mat_mat_almacen}}`.
 */
class m230425_151929_create_mat_mat_almacen_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%mat_mat_almacen}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codart'=> $this->string(14)->append($this->collateColumn()),
             'codal'=> $this->char(4)->append($this->collateColumn()),
             'ceconomica'=>$this->decimal(8,3) ,
             'creorden'=>$this->decimal(8,3) ,  
              'crepo'=>$this->decimal(8,3) , 
              'leadtime'=>$this->integer(4) ,    
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
