<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%factudet}}`.
 */
class m220626_024039_create_factudet_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_factudet}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'factu_id'=>$this->integer(11),
            'item'=>$this->char(3)->append($this->collateColumn()),
            'codsoc'=>$this->char(1)->append($this->collateColumn()),
            'codcen'=>$this->char(4)->append($this->collateColumn()),
           // 'codal'=>$this->char(4)->append($this->collateColumn()),
            'codum'=>$this->string(4)->append($this->collateColumn()),
            'codart'=>$this->string(14)->append($this->collateColumn()),
            'punit'=>$this->decimal(10,2),
            'pventa'=>$this->decimal(10,2),
            'cant'=>$this->decimal(6,2),
            'descripcion'=>$this->string(200)->append($this->collateColumn()),
            'igv'=>$this->decimal(8,2),
            'descuento'=>$this->decimal(8,2),
            'sunat_codtipoprecio'=>$this->char(2)->append($this->collateColumn()),
            'sunat_codtributo'=>$this->char(4)->append($this->collateColumn()),
            'sunat_codtipoafectacion'=>$this->char(2)->append($this->collateColumn()),
        ],$this->collateTable());
     
      }
        $this->paramsFk=[
                    $this->table,
                    'codart',
                    '{{%maestrocompo}}',
                    'codart'
                    ];
       $this->addFk();
        $this->paramsFk=[
                    $this->table,
                    'codcen',
                    '{{%centros}}',
                    'codcen'
                    ];
       $this->addFk();
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
