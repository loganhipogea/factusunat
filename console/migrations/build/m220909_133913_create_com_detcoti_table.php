<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%com_detcoti}}`.
 */
class m220909_133913_create_com_detcoti_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_detcoti}}';    
    public function safeUp()
    { 
            if(!$this->existsTable($this->table)) {
                $this->createTable($this->table, [
                    'id' => $this->primaryKey(),
                    'coti_id'=>$this->integer(11),
                    'item'=>$this->char(3),
                    'tipo'=>$this->char(3)->comment('tipo material o servicio'),
                    'codart'=>$this->string(14),
                    'descripcion'=>$this->string(60),
                    'detalle'=>$this->text(),
                    'codum'=>$this->string(4),
                    'cant'=>$this->decimal(10,4),
                    'punit'=>$this->decimal(10,4),
                    'ptotal'=>$this->decimal(12,4),
                    'igv'=>$this->decimal(8,2),
                    'pventa'=>$this->decimal(12,4),
                ],$this->collateTable()); 
                
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
