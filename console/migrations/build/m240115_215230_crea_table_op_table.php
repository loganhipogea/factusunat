<?php

use console\migrations\baseMigration;

/**
 * Class m240115_215230_crea_table_op_table
 */
class m240115_215230_crea_table_op_table extends baseMigration
{
     /**
     * {@inheritdoc}
     */
   
    
    public $table='{{%prd_op}}';
    
    public function safeUp()
    {
        if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
              'parent_id'=>$this->integer(11)->notNull(),
            'numero'=>$this->string(12)->append($this->collateColumn()),
             'codart'=>$this->string(14)->append($this->collateColumn()),          
            'descripcion'=>$this->string(80)->append($this->collateColumn()),
            'textodetalle'=>$this->text()->append($this->collateColumn()),
            'textocomercial'=>$this->text()->append($this->collateColumn()),
            'cant'=>$this->decimal(8,2)->notNull(),
            'username'=>$this->string(20)->append($this->collateColumn()),
            'finicio'=>$this->string(10)->append($this->collateColumn()),
            'finiciop'=>$this->string(10)->append($this->collateColumn()),
             'ftermino'=>$this->string(10)->append($this->collateColumn()),
            'fterminop'=>$this->string(10)->append($this->collateColumn()),
            'fcrea'=>$this->string(19)->append($this->collateColumn()),
            'avance'=>$this->integer(2),
            'tipo'=>$this->char(2)->append($this->collateColumn()),
            'codestado'=>$this->char(2)->append($this->collateColumn()),
            ],
           $this->collateTable()
		   );
        $this->putCombo($this->table, 'tipo', [
           '10'=> 'ENSAMBLE GENERAL',
            '20'=>'COMPONENTES',
            
        ]);
        
         $this->putCombo($this->table, 'codestado', [
           '10'=>  'CREADO',
           '20'=>  'APROBADO',
           '30'=>  'TERMINADO',
           '99'=>  'ANULADO',
            
        ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        if($this->existsTable($this->table)) {
       $this->deleteCombo($this->table, 'tipo');
        $this->deleteCombo($this->table, 'codestado');
        $this->dropTable($this->table);
        
       }
    }
}
