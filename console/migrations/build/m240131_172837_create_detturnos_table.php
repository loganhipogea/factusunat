<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%detturnos}}`.
 */
class m240131_172837_create_detturnos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
   public $table='{{%detturnos}}';
    public function safeUp()
    {
        
        if (!$this->existsTable($this->table)){
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
                'codarea_id'=>$this->string(4)->append($this->collateColumn()),
                'turno_id'=>$this->integer(11),
                 'dia'=>$this->integer(1),               
                  'activo'=>$this->char(1)->append($this->collateColumn()),
                  'hi'=>$this->char(5)->append($this->collateColumn()),
                  'hf'=>$this->char(5)->append($this->collateColumn()),
                  'horas'=>$this->decimal(5,2),
             ]);
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if ($this->existsTable($this->table)){
                $this->dropTable($this->table);
         }
    }
}
