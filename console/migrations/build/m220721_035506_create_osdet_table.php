<?php
use console\migrations\baseMigration;
class m220721_035506_create_osdet_table extends baseMigration
{
    const TABLE='{{%op_osdet}}';
   const TABLE_OS='{{%op_os}}';
   const TABLE_PROCESOS='{{%op_procesos}}';
   public function safeUp()
    {
     $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
            'proc_id'=>$this->integer(11),
            'os_id'=>$this->integer(11),
            'finicio'=>$this->char(19)->append($this->collateColumn()),
           'termino'=>$this->char(19)->append($this->collateColumn()),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
           'item'=>$this->char(3)->append($this->collateColumn()),
            'emplazamiento'=>$this->char(1)->append($this->collateColumn()),
           'codtra'=>$this->char(6)->append($this->collateColumn()),
            'tipo'=>$this->char(1)->append($this->collateColumn()),
           'tarifa'=>$this->char(1)->append($this->collateColumn()),
            'detalle' =>  $this->text()->append($this->collateColumn()),
            'valor' =>  $this->decimal(12,3),
            'numero' => $this->string(9)->notNull(),
           'interna'=>$this->char(1)->append($this->collateColumn()),
          
            ],
           $this->collateTable());
       $this->paramsFk=[
            $table,
            'os_id',
            static::TABLE_OS,
            'id'
        ];
        $this->addFk();
        
         $this->paramsFk=[
            $table,
            'proc_id',
            static::TABLE_PROCESOS,
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
        if ($this->existsTable(static::TABLE)) {
            $this->dropTable(static::TABLE);
        }
    }

    
}
