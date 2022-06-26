<?php
use console\migrations\baseMigration;
class m220625_150947_create_comfactura_table extends baseMigration
{
    public $table='{{%com_factura}}';    
    public function safeUp()
    { 
  
   if(!$this->existsTable($this->table)) {
         $this->createTable($this->table, [
             'id' => $this->primaryKey(),
             'codsoc'=>$this->char(1)->append($this->collateColumn()),
             'numero'=>$this->string(13)->append($this->collateColumn()),
             'femision'=>$this->char(10)->append($this->collateColumn()),
             'fvencimiento'=>$this->char(10)->append($this->collateColumn()),
             'sunat_tipodoc'=>$this->char(2)->append($this->collateColumn()),
             'codmon'=>$this->string(4)->append($this->collateColumn()),
             'tipopago'=>$this->char(2)->append($this->collateColumn()),
             'rucpro'=>$this->string(14)->append($this->collateColumn()),
             'sunat_hemision'=>$this->string(11)->append($this->collateColumn()),
             'sunat_hemision'=>$this->string(11)->append($this->collateColumn()),
             'codcen'=>$this->string(5)->append($this->collateColumn()),
        ]);
      }
    }
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
