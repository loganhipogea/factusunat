<?php
use console\migrations\baseMigration;
class m220620_150117_create_comov_table extends baseMigration
{
    public $table='{{%com_ov}}'; 
    const TABLE_NAME_CENTROS='{{%centros}}';
    /*const TABLE_NAME_CENTROS='{{%centros}}';
    const TABLE_NAME_ALMACENES='{{%almacenes}}';*/
    public function safeUp()
    { 
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'rucodni'=>$this->string(14)->notNull()->append($this->collateColumn()),
            'codcen'=>$this->char(4)->notNull()->append($this->collateColumn()),
            'codsoc' =>  $this->char(1)->append($this->collateColumn()),
            'tipodoc' =>  $this->char(3)->append($this->collateColumn()),
             'tipopago' =>  $this->char(3)->append($this->collateColumn()),
             'numero'=>$this->string(14)->notNull()->append($this->collateColumn()),
            ],
           $this->collateTable());
        $this->paramsFk=[
            $this->table,
            'codcen',
            self::TABLE_NAME_CENTROS,
            'codcen'
                ];
        
         $this->addFk();
         $this->putCombo($this->table,'tipodoc', ['10'=>'BOLETA','20'=>'FACTURA']);
         $this->putCombo($this->table,'tipopago', [
             '10'=>'EFECTIVO',
             '20'=>'YAPE',
              '30'=>'TARJETA POS',
             ]);
         
       /*$this->addForeignKey($this->generateNameFk($table),
                    $table,'pago_id', static::TABLE_PORPAGAR,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'tipomov', static::TABLE_TIPOMOV,'codigo');*/
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
