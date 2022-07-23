<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%matatenciones}}`.
 */
class m220722_132634_create_matatenciones_table extends baseMigration
{
    const TABLE='{{%mat_atenciones}}';
   const TABLE_DETVALE='{{%mat_detvale}}';
    const TABLE_DETREQ='{{%mat_detreq}}';
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
            'detreq_id' => $this->integer(11)->notNull(),
            'detvale_id' => $this->integer(11)->notNull(),
            'cant' =>  $this->decimal(10,4)->notNull(),           
            ],
           $this->collateTable());
       
       $this->paramsFk=[
            self::TABLE,
            'detreq_id',
           static::TABLE_DETREQ,
            'id'
                    ];
            $this->addFk();
            
        $this->paramsFk=[
            self::TABLE,
            'detvale_id',
           static::TABLE_DETVALE,
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
