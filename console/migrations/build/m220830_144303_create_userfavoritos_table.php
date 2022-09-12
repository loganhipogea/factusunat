<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%userfavoritos}}`.
 */
class m220830_144303_create_userfavoritos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%userfavoritos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(11),
            'url'=>$this->string(125),
            'alias'=>$this->string(30),
            'ishome'=>$this->char(1),
            'order'=>$this->integer(3)
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
