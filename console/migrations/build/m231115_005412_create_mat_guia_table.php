<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%mat_guia}}`.
 */
class m231115_005412_create_mat_guia_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    
    public $table='{{%mat_guia}}';
    
    public function safeUp()
    {
         if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codpro'=>$this->string(10)->append($this->collateColumn()),
            'codtra'=>$this->string(10)->append($this->collateColumn()),
            'fecha'=>$this->char(10)->append($this->collateColumn()),
            'fectra'=>$this->char(10)->append($this->collateColumn()),
            'numero'=>$this->string(14)->append($this->collateColumn()),
             'codcen'=>$this->string(5)->append($this->collateColumn()),
            'descripcion'=>$this->string(40)->append($this->collateColumn()),
            'placa'=>$this->string(20)->append($this->collateColumn()),
	    'detalle'=>$this->text()->append($this->collateColumn()),
            ],
           $this->collateTable()
		   );
         }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
          if($this->existsTable($this->table)) {
        $this->dropTable($this->table);
          }
    }
}
