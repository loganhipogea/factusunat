<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_areas}}`.
 */
class m240118_212220_create_table_areas_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    
    public $table='{{%areas}}';
    public function safeUp()
    {
        if(!$this->existsTable($this->table)){
             $this->createTable($this->table, [
            'codarea' => $this->string(4)->append($this->collateColumn()),
            'desarea'=>$this->string(40)->append($this->collateColumn()),
            'detalle'=>$this->text()->append($this->collateColumn()),
            
        ],$this->collateTable());
         $this->addPrimaryKey($this->generateNameFk(),$this->table, 'codarea'); 
        }
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if(!$this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
