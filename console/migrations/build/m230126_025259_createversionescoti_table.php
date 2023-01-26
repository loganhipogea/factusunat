<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%versionescoti}}`.
 */
class m230126_025259_createversionescoti_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_cotiversiones}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
          $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'coti_id'=>$this->integer(11),
             'numero'=>$this->decimal(5,2), 
              'cuando'=>$this->string(19),
              'detalles'=>$this->text(),
              
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
