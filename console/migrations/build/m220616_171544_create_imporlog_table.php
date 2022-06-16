<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%imporlog}}`.
 */
class m220616_171544_create_imporlog_table extends baseMigration
{
     public $table='{{%import_logcargamasiva}}';
     const NAME_TABLE_PARENT='{{%import_carga_user}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
      
      
if(!$this->existsTable($this->table)) {
    $this->createTable($this->table, [
             'id'=>$this->primaryKey(),
            'cargamasiva_id' => $this->integer(11)->notNull(),//id padre
               'nombrecampo' => $this->string(60)->notNull()->append($this->collateColumn()),//codigo activo
        'mensaje'=>$this->string(180)->notNull()->append($this->collateColumn()),
        'level'=>$this->char(1)->append($this->collateColumn()),
        'fecha'=>$this->string(20)->append($this->collateColumn()),
         'user_id'=>$this->integer(4)->notNull(),
        'numerolinea'=>$this->integer(4)->notNull()
          ],$this->collateTable());
          $this->paramsFk=[
              $this->table,
               'cargamasiva_id',
              static::NAME_TABLE_PARENT,
              'id'
          ];
              $this->addFk(); 
              
            }
 }

public function safeDown()
    {
    
       if($this->existsTable($this->table)) {
            $this->dropTable($this->table);
        }

    }

}
