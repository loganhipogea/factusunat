<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%FKS}}`.
 */
class m220610_061903_create_FKS_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%fks}}';    
    public function safeUp()
    
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name'=>$this->string(200),
            'tabla_origen'=>$this->string(80),
            'campo_origen'=>$this->string(80),
            'tabla_destino'=>$this->string(80),
             'campo_destino'=>$this->string(80),
              'exito'=>$this->char(1),
              'error'=>$this->text(),
    
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
