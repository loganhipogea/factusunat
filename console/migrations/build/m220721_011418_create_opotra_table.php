<?php
use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%opotra}}`.
 */
class m220721_011418_create_opotra_table extends baseMigration
{
    const TABLE='{{%op_otra}}';
   const TABLE_TRABAJADORES='{{%trabajadores}}';
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
            'numero' => $this->string(8)->notNull(),
            'fecha' =>  $this->char(10)->append($this->collateColumn()),
            'placa' =>  $this->string(14)->append($this->collateColumn()),
            'fsalida' =>  $this->char(19)->append($this->collateColumn()),
            'fregreso' =>  $this->char(19)->append($this->collateColumn()),
            'user_id' =>  $this->integer(11),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),
           'descripcion' =>  $this->string(40)->append($this->collateColumn()),
            'texto' =>  $this->text()->append($this->collateColumn()),
            'codest' =>  $this->char(3)->append($this->collateColumn()),
            ],
           $this->collateTable());
        $this->paramsFk=[
            self::TABLE,
            'codtra',
            '{{%trabajadores}}',
            'codigotra'
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
