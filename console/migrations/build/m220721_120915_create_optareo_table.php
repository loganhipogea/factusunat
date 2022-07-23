<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%optareo}}`.
 */
class m220721_120915_create_optareo_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%optareo}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
$this->createTable($this->table, [
            'id' => $this->primaryKey(),
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
