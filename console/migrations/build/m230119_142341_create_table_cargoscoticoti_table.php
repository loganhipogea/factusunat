<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_cargoscoticoti}}`.
 */
class m230119_142341_create_table_cargoscoticoti_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_cargoscoti}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'coti_id'=>$this->integer(11),
            'cargo_id'=>$this->integer(11),
            'porcentaje'=>$this->decimal(5,2),
            'monto'=>$this->decimal(9,2),
        ]);
       $this->paramsFk=[
            $this->table,
            'cargo_id',
            '{{%com_cargos}}',
            'id'
                    ];
            $this->addFk();     
            
        $this->paramsFk=[
            $this->table,
            'coti_id',
            '{{%com_cotizaciones}}',
            'id'
                    ];
            $this->addFk();       
            
            
            
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
