<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%comcoticeco}}`.
 */
class m221217_152557_create_comcoticeco_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_coticeco}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
$this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'coti_id'=> $this->integer(11),
            'ceco_id'=> $this->integer(11),
            'tipo'=> $this->char(1),
            'descricecoti'=> $this->string(40)->append($this->collateColumn()), 
            'detalle'=> $this->text()->append($this->collateColumn()), 
          'subto'=> $this->decimal(10,3),
        ], $this->collateTable());

        $this->paramsFk=[
            $this->table,
            'coti_id',
            '{{%com_cotizaciones}}',
            'id'
                    ];
            $this->addFk();
        $this->paramsFk=[
            $this->table,
            'ceco_id',
            '{{%cc_cc}}',
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
