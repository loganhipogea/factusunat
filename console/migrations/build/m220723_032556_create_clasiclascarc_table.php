<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%clasiclascarc}}`.
 */
class m220723_032556_create_clasiclascarc_table extends baseMigration
{
    const TABLE='{{%clasi_clase_carac}}';
   const NAME_TABLE_CLASES='{{%clasi_clases}}';
   const NAME_TABLE_CARACTERISTICAS='{{%clasi_caracteristicas}}';
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
           // 'id'=>$this->primaryKey(),
            'codigo' => $this->string(31)->notNull(),
            'clase_id'=>$this->string(15)->notNull(),
           'carac_id'=>$this->string(15)->notNull(),
           'tipovalor'=>$this->char(1),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'user_id'=>$this->integer(4)
            ],
           $this->collateTable());
        $this->addPrimaryKey(
                $this->generateNameFk($table),
               $table,
                'codigo');  
      $this->paramsFk=[
            self::TABLE,
            'clase_id',
            static::NAME_TABLE_CLASES,
            'codigo'
                    ];
            $this->addFk();
      $this->paramsFk=[
            self::TABLE,
            'carac_id',
            static::NAME_TABLE_CARACTERISTICAS,
            'codigo'
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
