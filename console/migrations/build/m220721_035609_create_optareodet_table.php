<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%optareodet}}`.
 */
class m220721_035609_create_optareodet_table extends baseMigration
{
    const TABLE='{{%op_tareodet}}';
    const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';
    const TABLE_TARIFAS='{{%op_planestarifa}}';
  //const TABLE_DIRECCIONES='{{%direcciones}}';
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
            'tareo_id'=>$this->integer(11)->notNull(),
           'hinicio' =>$this->char(5)->append($this->collateColumn()),
            'hfin' =>$this->char(5)->append($this->collateColumn()),
           'proc_id'=>$this->integer(11)->notNull(),
           'os_id'=>$this->integer(11)->notNull(),
           'detos_id'=>$this->integer(11)->notNull(),
           'codtra'=>$this->char(6)->append($this->collateColumn()),
            'descripcion'=>$this->string(40)->append($this->collateColumn()),
           'detalle'=>$this->text()->append($this->collateColumn()),
           'tarifa_id'=>$this->integer(11)->notNull(),
           'costo'=>$this->decimal(8,3),
           'htotales' =>$this->decimal(5,2),
           
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
            'os_id',
            static::TABLE_OS,
            'id'
                    ];
            $this->addFk(); 
       
             $this->paramsFk=[
            self::TABLE,
            'detos_id',
            static::TABLE_OSDET,
            'id'
                    ];
            $this->addFk();
            
        $this->paramsFk=[
            self::TABLE,
            'proc_id',
            static::TABLE_PROCESOS,
            'id'
                    ];
            $this->addFk(); 
            
         $this->paramsFk=[
            self::TABLE,
            'tarifa_id',
            static::TABLE_TARIFAS,
            'id'
                    ];
            $this->addFk();
            
           $this->paramsFk=[
            self::TABLE,
            'tareo_id',
            static::TABLE_TAREO,
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
