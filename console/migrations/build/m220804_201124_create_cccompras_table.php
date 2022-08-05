<?php

use console\migrations\baseMigration;
class m220804_201124_create_cccompras_table extends baseMigration
{
    const TABLE='{{%cc_compras}}';
    //const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';
    const TABLE_DOCUMENTOS='{{%documentos}}';
    const TABLE_CLIPRO='{{%clipro}}';
    //const TABLE_TARIFAS='{{%op_planestarifa}}';
  //const TABLE_DIRECCIONES='{{%direcciones}}';
  //const TABLE_TRABAJADORES='{{%trabajadores}}';
    // const TABLE_MOVIMIENTOS_BANCO='{{%sigi_movbanco}}';
    // const TABLE_TIPOMOV='{{%sigi_tipomov}}';
    //const TABLE_CARRERAS='{{%carreras}}';
    //const TABLE_CURSOS='{{%cursos}}';
    public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
            'codocu'=>$this->char(3)->append($this->collateColumn()),
            'prefijo'=>$this->string(4)->append($this->collateColumn()),
            'numero'=>$this->string(12)->append($this->collateColumn()),
            'fecha'=>$this->char(10)->append($this->collateColumn()),
           'mes'=>$this->integer(2)->notNull(),
           'anio'=>$this->char(4)->append($this->collateColumn()),
            'glosa'=>$this->string(50)->append($this->collateColumn()),
            'codmon'=>$this->char(3)->append($this->collateColumn()),
           'monto'=>$this->decimal(11,3),
           'igv'=>$this->decimal(9,3),
           'movimiento_id'=>$this->integer(11),
           'codpro'=>$this->char(10)->append($this->collateColumn()),
            'rucpro'=>$this->string(14)->append($this->collateColumn()),
            'monto_usd'=>$this->decimal(11,3),
            'igv_usd'=>$this->decimal(9,3),
            'activo' =>$this->char(1)->append($this->collateColumn()),
            'detalle' =>$this->text()->append($this->collateColumn()),
            'frecuencia'=>$this->integer(3),
            'parent_id'=>$this->integer(11),
            'codtra'=>$this->char(6)->append($this->collateColumn()),
            'monto_a_rendir'=>$this->decimal(11,3),
           'monto_calificado'=>$this->decimal(11,3),
            ],
           $this->collateTable());
       
       $this->paramsFk=[
           static::TABLE,
           'codocu',
           static::TABLE_DOCUMENTOS,
           'codocu'
             ];
       $this->addFk();
       $this->paramsFk=[
           static::TABLE,
           'codpro',
          static::TABLE_CLIPRO,
           'codpro'
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
