<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%import}}`.
 */
class m220616_170515_create_import_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%import_cargamasiva}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'delimitador'=>$this->char(1)->notNull(),
            'user_id' => $this->integer(11)->notNull(),//id padre
               'insercion' => $this->char(1)->notNull()->append($this->collateColumn()),//codigo activo
         'tienecabecera' => $this->char(1)->notNull()->append($this->collateColumn()),//codigo activo
         ///'' => $this->char(1)->notNull()->append($this->collateColumn()),//codigo activo
        'escenario'=>$this->string(40)->notNull()->append($this->collateColumn()),
        'lastimport'=>$this->string(18)->append($this->collateColumn()),//ultimo fecha de importacion 
                'descripcion'=>$this->string(40)->notNull()->append($this->collateColumn()),
          'format'=>$this->char(3)->notNull()->append($this->collateColumn()),//formato de archi csv, xls
        'modelo'=>$this->string(180)->notNull()->append($this->collateColumn()),//formato de archi csv, xls
        
        ],$this->collateTable());

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
