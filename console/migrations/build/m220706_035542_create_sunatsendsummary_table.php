<?php
use console\migrations\baseMigration;
class m220706_035542_create_sunatsendsummary_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%sunat_send_sumary}}'; 
    public $table_factura='{{%com_factura}}';
    public function safeUp()
    {
     
  
      if(!$this->existsColumn($this->table_factura,'summary_id')){
         $this->addColumn($this->table_factura, 'summary_id', $this->integer(11));
      }

    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(),
            //'username'=>$this->string(50)->append($this->collateColumn()),
            'ticket'=>$this->string(100)->append($this->collateColumn())
             ->comment('Numero de ticket de respuesta de la SUNAT'),
            'codopera'=>$this->char(3)->append($this->collateColumn())
                ->comment('Tipo de operacion: EMISION DE BOLETA, ANULACION BOLETA, ANULACION FACRURA'),
            'motivo'=>$this->string(25)->append($this->collateColumn())
                ->comment('USAR SOLO EN EL CASO DE ANULACION DE UNA FACTURA O DOCUMENTO; ERROR EN RUC, ERROR EN MONTO ETC '),
            'femision'=>$this->char(10)->append($this->collateColumn()),
            //'fenvio'=>$this->char(10)->append($this->collateColumn()),
            'cuando'=>$this->char(19)->append($this->collateColumn())->comment('F hora de envio posteo'),
            'resultado'=>$this->char(1)->append($this->collateColumn()),
            'mensaje'=>$this->text(),
            'caja_id'=>$this->integer(11)->comment('Uso solo para enviar boletas del resumen diario,colocar el id de la caja diaria'),
            //'tipodoc'=>$this->string(3)->append($this->collateColumn()),
            
        ]);
      }
      
      $this->putCombo($this->table,'codopera',
      [
          '10'=>'EMISION BOLETAS',
          '20'=>'ANULACION BOLETA',
          '30'=>'ANULACION FACTURA',
          '40'=>'ANULACION GUIA',          
          '50'=>'ANULACION NOTA DE CREDITO',         
          
      ]);
      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsColumn($this->table_factura,'summary_id')){
         $this->dropColumn($this->table_factura, 'summary_id');
          }
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
    
  
}
