<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%opdespiece}}`.
 */
class m240119_234933_create_opdespiece_table extends baseMigration
{
  public $table='{{%op_osdespiece}}';
   
    public function safeUp()
    {
        
       // $this->table=static::NAME_TABLE;
if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id'=>$this->primaryKey(),
            'os_id'=>$this->integer(11),
            'parent_id'=>$this->integer(11),
            'ruta'=>$this->text()->append($this->collateColumn()),
              'ruta2'=>$this->text()->append($this->collateColumn()),            
            'abreviatura'=>$this->string(14)->unique()->notNull()->append($this->collateColumn()),
             'clave'=>$this->string(20)->append($this->collateColumn()),
             'final'=>$this->char(1)->append($this->collateColumn()),
            'nivel'=>$this->integer(2),
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
