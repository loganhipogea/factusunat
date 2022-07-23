<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%oss}}`.
 */
class m220721_013816_create_oss_table extends baseMigration
{
    const TABLE='{{%op_os}}';
   const TABLE_CLIPRO='{{%clipro}}';
   const TABLE_PROCESOS='{{%op_procesos}}';
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
            'proc_id'=>$this->integer(11)->notNull(),
            'numero' => $this->string(9)->notNull(),
            'fechaprog' =>  $this->char(10)->append($this->collateColumn()),
           'fechaini' =>  $this->char(10)->append($this->collateColumn()),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),         
            //'numoc' =>  $this->string(14)->append($this->collateColumn()),
           'codpro' =>  $this->string(10)->append($this->collateColumn()),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'tipo' =>  $this->char(1)->append($this->collateColumn()),
            'codestado' =>  $this->char(2)->append($this->collateColumn()),
            'textocomercial' =>  $this->text()->append($this->collateColumn()),
            'textointerno' =>  $this->text()->append($this->collateColumn()),
            'textotecnico' =>  $this->text()->append($this->collateColumn()),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),
            
            ],
           $this->collateTable());
        $this->paramsFk=[
            self::TABLE,
            'codpro',
            '{{%clipro}}',
            'codpro'
        ];
        $this->addFk();
         $this->paramsFk=[
            self::TABLE,
            'proc_id',
            '{{%op_procesos}}',
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
