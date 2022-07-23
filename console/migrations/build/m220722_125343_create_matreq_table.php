<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%matreq}}`.
 */
class m220722_125343_create_matreq_table extends baseMigration
{
    const TABLE='{{%mat_req}}';
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
            'numero' => $this->string(10)->notNull(),
            'fechaprog' =>  $this->char(10)->append($this->collateColumn()),
            'fechasol' =>  $this->char(10)->append($this->collateColumn()),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),
           'descripcion' =>  $this->string(40)->append($this->collateColumn()),
            'texto' =>  $this->text()->append($this->collateColumn()),
            'codest' =>  $this->char(3)->append($this->collateColumn()),
            ],
           $this->collateTable());
       
        $this->paramsFk=[
            self::TABLE,
            'codtra',
           static::TABLE_TRABAJADORES,
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
