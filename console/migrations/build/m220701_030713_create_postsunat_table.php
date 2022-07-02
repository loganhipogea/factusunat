<?php

use console\migrations\baseMigration;
use yii\helpers\Json;
/**
 * Handles the creation of table `{{%postsunat}}`.
 */
class m220701_030713_create_postsunat_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%sunat_sends}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(),
            'username'=>$this->string()->append($this->collateColumn()),
            'cuando'=>$this->char(19)->append($this->collateColumn()),
            'resultado'=>$this->char(1)->append($this->collateColumn()),
            'mensaje'=>$this->text(),
            'doc_id'=>$this->integer(),
            'tipodoc'=>$this->string(3)->append($this->collateColumn()),
            
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
