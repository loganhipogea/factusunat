<?php

use yii\db\Migration;

/**
 * Class m220830_225519_create_table_fondorendicion
 */
class m220830_225519_create_table_fondorendicion extends \console\migrations\baseMigration
{
    public $table='{{%cc_rendicion}}';
    
    public function safeUp(){
   if(!$this->existsTable($this->table)) {
         $this->createTable($this->table, [
             'id' => $this->primaryKey(),
             'movimiento_id'=>$this->integer(11),
             'codcen'=>$this->string(5)->append($this->collateColumn()),
             'codsoc'=>$this->char(1)->append($this->collateColumn()),
             'numero'=>$this->string(10)->append($this->collateColumn()),
             'fecha'=>$this->char(10)->append($this->collateColumn()),
             'fvencimiento'=>$this->char(10)->append($this->collateColumn()),
             'codmon'=>$this->string(4)->append($this->collateColumn()),
             'monto'=>$this->decimal(10,2),
             'monto_rendido'=>$this->decimal(10,2),
             'codtra'=>$this->char(6)->append($this->collateColumn()),
             'estado'=>$this->char(2)->append($this->collateColumn()),
             'tipopago'=>$this->char(2)->append($this->collateColumn()),
             'descripcion'=>$this->string(40)->append($this->collateColumn()),
             'detalle'=>$this->text()->append($this->collateColumn()),
            
        ],$this->collateTable());
         
         $this->paramsFk=[
            $this->table,
            'movimiento_id',
            '{{%cc_movimientos}}',
            'id'
                ];
           $this->addFk();
         
         $this->paramsFk=[
            $this->table,
            'codtra',
            '{{%trabajadores}}',
            'codigotra'
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
    }
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
