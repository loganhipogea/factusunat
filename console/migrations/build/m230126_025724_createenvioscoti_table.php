<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%envioscoti}}`.
 */
class m230126_025724_createenvioscoti_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_cotienvios}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
             'version_id'=>$this->integer(11), 
            'coti_id'=>$this->integer(11),
             'canal'=>$this->string(5), 
              'exito'=>$this->string(19),
              'destinatarios'=>$this->text(),
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
