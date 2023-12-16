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
       $this->putCombo($this->table, 'fpago', [
                 '10'=> 'CONTADO',
                   '20'=> 'FACTURA 30 DIAS',
                   '30'=>'FACTURA 15 DIAS',
                   '40'=>'FACTURA 45 DIAS',
                   '50'=> 'CHEQUE DIFERIDO',
                 
                  ]); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
