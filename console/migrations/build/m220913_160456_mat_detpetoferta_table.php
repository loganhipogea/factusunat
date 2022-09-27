<?php

use yii\db\Migration;

/**
 * Class m220913_160456_mat_detpetoferta_table
 */
class m220913_160456_mat_detpetoferta_table extends console\migrations\baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%mat_detpetoferta}}';    
    public function safeUp()
    { 
            if(!$this->existsTable($this->table)) {
                $this->createTable($this->table, [
                    'id' => $this->primaryKey(),
                    'petoferta_id'=>$this->integer(11),
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
            'petoferta_id',
            '{{%mat_petoferta}}',
            'id'
                    ];
            $this->addFk();
            $this->putCombo($this->table,'tipo', [
                '10'=>'MATERIALES',
                '20'=>'SERVICIOS',
            ]);
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
