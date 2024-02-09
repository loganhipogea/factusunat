<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%cambioturno}}`.
 */
class m240201_130936_create_cambioturno_table extends baseMigration
{ /**
     * {@inheritdoc}
     */
   public $table='{{%turnosasignaciones}}';
    public function safeUp()
    {
        
        if (!$this->existsTable($this->table)){
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
                    'trabajcuadrilla_id'=>$this->integer(11),
                     'codtra_id'=>$this->integer(11),  
                    'codtra'=>$this->char(6)->append($this->collateColumn()),
                    'descripcion'=>$this->string(40)->append($this->collateColumn()),
                    'fecha'=>$this->char(10)->append($this->collateColumn()),
                    'turno_id'=>$this->integer(11),
                   // 'turnoactual_id'=>$this->integer(11),
                    'activo'=>$this->char(1)->append($this->collateColumn()),
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
