<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%turnos}}`.
 */
class m240131_172825_create_turnos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
   public $table='{{%turnos}}';
    public function safeUp()
    {
        
        if (!$this->existsTable($this->table)){
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
                'codarea_id'=>$this->string(4)->append($this->collateColumn()),
                 'desturno'=>$this->string(40)->append($this->collateColumn()),
                'detalle'=>$this->text()->append($this->collateColumn()),
               'hsemanal'=>$this->decimal(5,2),
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
