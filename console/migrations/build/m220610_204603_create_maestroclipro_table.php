<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%maestroclipro}}`.
 */
class m220610_204603_create_maestroclipro_table extends baseMigration
{
 public $table= '{{%maestroclipro}}';
 //const NAME_TABLE='{{%maestroclipro}}';
  const NAME_TABLE_CLIPRO='{{%clipro}}';
   const NAME_TABLE_MAESTRO='{{%maestrocompo}}';
    public function safeUp()
    {
       
    if (!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
             'id'=>$this->primaryKey(),
            'venta'=>$this->char(1)->append($this->collateColumn()), //define si es venta o compra
            'codpro' => $this->char(6)->append($this->collateColumn()),
            'codart' => $this->string(14)->append($this->collateColumn()),
            'vencimiento' => $this->integer(),
            'tiempoentrega'=>$this->integer(),
              'codcen' =>$this->string(5)->append($this->collateColumn()),
            'precio'=>$this->double(3),
            'codmon' => $this->string(4)->append($this->collateColumn()),
            'param1' => $this->char(2)->append($this->collateColumn()),
            'param2' => $this->char(2)->append($this->collateColumn()),
             'param3' => $this->char(1)->append($this->collateColumn()),
            'param4' => $this->string(10)->append($this->collateColumn()),
             ],$this->collateTable());
        $this->paramsFk=[
            $this->table,
            'codpro',
            self::NAME_TABLE_CLIPRO,
            'codpro'
                ];
    $this->addFk();
      $this->paramsFk=[
            $this->table,
             'codart',
            self::NAME_TABLE_MAESTRO,
            'codart'
                ];
         $this->addFk();
}
    
    }

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      if ($this->existsTable($this->table)) {
            $this->dropTable($this->table);
        }

    }
}
