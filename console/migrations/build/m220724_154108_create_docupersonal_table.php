<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%docupersonal}}`.
 */
class m220724_154108_create_docupersonal_table extends baseMigration
{ const TABLE='{{%docutrabajadores}}';
   const TABLE_TRABAJADORES='{{%trabajadores}}';
    //const TABLE_CLIPRO='{{%clipro}}';
    
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
           'codocu' =>  $this->char(3)->append($this->collateColumn()),
           'codtra' =>  $this->char(6)->append($this->collateColumn()),
            'numero' => $this->string(20)->notNull(),           
            'fvence' =>  $this->char(10)->append($this->collateColumn()),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'textointerno' =>  $this->text()->append($this->collateColumn()),           
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
