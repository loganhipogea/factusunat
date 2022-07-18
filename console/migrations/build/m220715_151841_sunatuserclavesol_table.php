<?php
use console\migrations\baseMigration;
class m220715_151841_sunatuserclavesol_table extends baseMigration
{
    public $table='{{%sunat_access}}';    
    public function safeUp()
    {
    
        if(!$this->existsTable($this->table)) {
            
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codsoc'=>$this->string(2)->append($this->collateColumn()),
            'user'=>$this->string(60)->append($this->collateColumn())->comment('USUARIO SECUNDARIO SOL SUNAT'),
            'password'=>$this->string(300)->append($this->collateColumn()),
            'path_store_cert'=>$this->string(400)->append($this->collateColumn())->comment('RUTA A LA CARPETA DONDE SE GUARAD EL ARCHIVO DEL CERTIDICADO'),
            ],$this->collateTable());
     
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
