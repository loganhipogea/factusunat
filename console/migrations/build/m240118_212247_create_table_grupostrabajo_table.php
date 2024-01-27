<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_grupostrabajo}}`.
 */
class m240118_212247_create_table_grupostrabajo_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    
   public $table='{{%grupostrabajo}}';  
    
    public function safeUp()
    {
        if(!$this->existsTable($this->table)){
           $this->createTable($this->table, [
            'codgrupo' => $this->string(5)->append($this->collateColumn()),
            'desgrupo'=>$this->string(40)->append($this->collateColumn()),
            'detalle'=>$this->text()->append($this->collateColumn()),
            
        ],$this->collateTable());
             $this->addPrimaryKey($this->generateNameFk($this->table),$this->table, 'codgrupo');
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
