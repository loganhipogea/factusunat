<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%matoc}}`.
 */
class m220722_134621_create_matoc_table extends baseMigration
{
    const TABLE='{{%mat_oc}}';
   const TABLE_TRABAJADORES='{{%trabajadores}}';
    const TABLE_CLIPRO='{{%clipro}}';
    
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
            'numero' => $this->string(10)->notNull(),
            'fecha' =>  $this->char(10)->append($this->collateColumn()),
            //'fechasol' =>  $this->char(10)->append($this->collateColumn()),
            'codpro' =>  $this->string(10)->append($this->collateColumn()),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),
           'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'textointerno' =>  $this->text()->append($this->collateColumn()),
            'fpago' =>  $this->char(2)->append($this->collateColumn()),
           'texto' =>  $this->text()->append($this->collateColumn()),
            'codest' =>  $this->char(2)->append($this->collateColumn()),
            'codmon' =>  $this->char(3)->append($this->collateColumn()),
           'user_id'=>$this->integer(4)
            ],
           $this->collateTable());
       $this->paramsFk=[
            self::TABLE,
            'codtra',
            static::TABLE_TRABAJADORES,
            'codigotra'
                    ];
            $this->addFk();
        $this->paramsFk=[
            self::TABLE,
            'codpro',
           static::TABLE_CLIPRO,
            'codpro'
                    ];
            $this->addFk();
        $this->putCombo($table, 'fpago', [
                 '10'=> 'CONTADO',
                   '20'=> 'FACTURA 30 DIAS',
                   '30'=>'FACTURA 15 DIAS',
                   '40'=>'FACTURA 45 DIAS',
                   '50'=> 'CHEQUE DIFERIDO',
                 
                  ]);
       
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
