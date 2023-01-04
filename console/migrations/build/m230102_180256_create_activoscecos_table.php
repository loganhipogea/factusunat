<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%activoscecos}}`.
 */
class m230102_180256_create_activoscecos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%mat_activoscecos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
$this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'activo_id'=>$this->integer(11),
            'ceco_id'=>$this->integer(11),
            'codmon'=>$this->string(5),
            'valor'=>$this->decimal(9,3),
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
