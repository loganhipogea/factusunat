<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_despiece}}`.
 */
class m231216_181956_create_table_despiece_table extends baseMigration
{
  public $table='{{%mat_despiece}}';
   
    public function safeUp()
    {
        
       // $this->table=static::NAME_TABLE;
if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id'=>$this->primaryKey(),
            'codart'=>$this->string(14)->unique()->notNull()->append($this->collateColumn()),
             'cant'=>$this->decimal(6,2),
           'clave'=>$this->string(20)->append($this->collateColumn()),
            'parent_id'=>$this->integer(11),
            'activo_id'=>$this->integer(11),
            'nivel'=>$this->integer(2),
             'ruta'=>$this->text()->append($this->collateColumn()),
              'ruta2'=>$this->text()->append($this->collateColumn()),
             'prioridad'=>$this->integer(2),
            ],
                $this->collateTable());
        
        
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
