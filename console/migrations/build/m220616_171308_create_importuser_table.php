<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%importuser}}`.
 */
class m220616_171308_create_importuser_table extends baseMigration
{
    public $table='{{%import_carga_user}}'; 
    const NAME_TABLE_CARGA='{{%import_cargamasiva}}';
    public function safeUp()
    {
       
if(!$this->existsTable($this->table)) {
    $this->createTable($this->table, [
                'id'=>$this->primaryKey(),
                'cargamasiva_id' => $this->integer(11)->notNull(),//
                'fechacarga'=>$this->string(18)->append($this->collateColumn()),//
                'user_id' => $this->integer(11),//
                'descripcion'=>$this->string(40)->notNull()->append($this->collateColumn()),
                'current_linea'=>$this->integer(11),//
        'current_linea_test'=>$this->integer(11),//
                'total_linea'=>$this->integer(11),//
         'estricto'=>$this->char(1)->append($this->collateColumn()),//Si carga con errores , ignora los erroes solo inserta los que pasan
         'activo'=>$this->char(2)->append($this->collateColumn()),
                'tienecabecera'=>$this->char(1)->append($this->collateColumn()),
                'duracion'=>$this->string(40)->append($this->collateColumn()),
        ],$this->collateTable());
             
                $this->paramsFk=[
                    $this->table,
                    'cargamasiva_id' ,
                    static::NAME_TABLE_CARGA,
                    'id'
                ];
                
               $this->addFK();
            }
 }

public function safeDown()
    {
    
       if($this->existsTable($this->table)) {
            $this->dropTable($this->table);
        }

    }

}
