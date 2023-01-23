<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%contactocoti}}`.
 */
class m230123_145235_create_contactocoti_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%contactocoti}}';    
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
