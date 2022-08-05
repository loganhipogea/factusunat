<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%cccc}}`.
 */
class m220804_221001_create_cccc_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%cc_cc}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
$this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codigo'=>$this->string(10),
             'parent_id' => $this->integer(11),
             'descripcion'=>$this->string(50),
            'activo'=>$this->char(1),
    'esorden'=>$this->char(1),
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
