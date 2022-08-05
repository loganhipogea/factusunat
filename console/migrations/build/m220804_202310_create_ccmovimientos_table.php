<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%ccmovimientos}}`.
 */
class m220804_202310_create_ccmovimientos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%cc_movimientos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'cuenta_id'=>$this->integer(11),
           'caja_id'=>$this->integer(11),
           'codtra'=>$this->char(6)->append($this->collateColumn()), 
            'fechaop'=>$this->string(10)->append($this->collateColumn()),  
            'fechacre'=>$this->string(19)->append($this->collateColumn()), 
             'glosa'=>$this->string(40)->append($this->collateColumn()),
             'monto'=>$this->decimal(12,3),
             'igv'=>$this->decimal(8,3), 
              'monto_eq'=>$this->decimal(12,3),  
             'user_id'=>$this->integer(4), 
              'activo'=>$this->char(1),
              'ingreso'=>$this->char(1), 
             'detalle'=>$this->text()->append($this->collateColumn()), 
               'tipo'=>$this->char(1),  
        ],
           $this->collateTable());
            
            
       $this->paramsFk=[
           $this->table,
           'cuenta_id',
           '{{%cc_cuentas}}',
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
