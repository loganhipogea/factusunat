<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%cuentas}}`.
 */
class m220617_035414_create_cuentas_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%cuentas}}';  
    const TABLE_CLIPRO='{{%clipro}}';
    const TABLE_BANCOS='{{%bancos}}';
    public function safeUp()
    {
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'tipo'=>$this->char(3)->append($this->collateColumn()),
            'codmon'=>$this->string(5)->append($this->collateColumn()),
            'codpro'=>$this->char(6)->append($this->collateColumn()),
             'nombre'=>$this->string(60)->append($this->collateColumn()),
             'numero'=>$this->string(100)->append($this->collateColumn()),
            'banco_id'=>$this->integer(11),
            'cci'=>$this->string(100)->append($this->collateColumn()),
            'detalles'=>$this->text(),
            
        ],$this->collateTable());
        $this->putCombo($this->table,'tipo', ['CORRIENTE','AHORROS']);
        $this->paramsFk=[$this->table,'codpro',self::TABLE_CLIPRO,'codpro'];
        $this->addFk();
         $this->paramsFk=[$this->table,'banco_id',self::TABLE_BANCOS,'id'];
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
