<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%factudet}}`.
 */
class m220626_025446_create_factudet_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%factudet}}';    
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
