<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%matdetvale}}`.
 */
class m220722_131200_create_matdetvale_table extends baseMigration
{
    
    const TABLE='{{%mat_detvale}}';
   const TABLE_MAESTRO='{{%maestrocompo}}';
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
            'vale_id'=>$this->integer(11)->notNull(),
            'item' =>$this->char(4)->append($this->collateColumn()),
            'cant' =>$this->decimal(8,3),
            'valor' =>$this->decimal(10,3),
            'um' =>  $this->string(4)->append($this->collateColumn()),
            //'numero' => $this->string(10)->notNull(),
            //'fecha' =>  $this->char(10)->append($this->collateColumn()),
            //'fechasol' =>  $this->char(10)->append($this->collateColumn()),
            'codart' => $this->char(6)->notNull()->append($this->collateColumn()),
            //'codmov' => $this->char(3)->notNull()->append($this->collateColumn()),
           //'descripcion' =>  $this->string(40)->append($this->collateColumn()),
           // 'texto' =>  $this->text()->append($this->collateColumn()),
            'codest' =>  $this->char(2)->append($this->collateColumn()),
            ],
           $this->collateTable());
       
       $this->paramsFk=[
            self::TABLE,
            'codart',
            static::TABLE_MAESTRO,
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
if ($this->existsTable(static::TABLE)) {
            $this->dropTable(static::TABLE);
        }
    }

    
}
