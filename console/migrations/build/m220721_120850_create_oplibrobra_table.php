<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%oplibrobra}}`.
 */
class m220721_120850_create_oplibrobra_table extends baseMigration
{
    const TABLE='{{%op_libro}}';
    const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';   
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
           'user_id'=>$this->integer(4)->notNull(),
           'os_id'=>$this->integer(11)->notNull(),
           'detos_id'=>$this->integer(11)->notNull(),
           //'codtra'=>$this->char(6)->append($this->collateColumn()),
            'descripcion'=>$this->string(40)->append($this->collateColumn()),
           'tipo'=>$this->char(3)->append($this->collateColumn()),
           'detalle'=>$this->text()->append($this->collateColumn()),
           //'tarifa_id'=>$this->integer(11)->notNull(),
           //'costo'=>$this->decimal(8,3),
          // 'htotales' =>$this->decimal(5,2),
           
            ],
           $this->collateTable());
             
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
            'detos_id',
           static::TABLE_PROCESOS,
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
              
         $this->putCombo($table, 'tipo', [
                  'TAREA ORDINARIA',
                   'INGRESO CARGA MATERIALES',
                  'SALIDA CARGA MATERIALES',
                  'INCIDENTE',
                   'ACCIDENTE',
                  'REUNION CLIENTE',
                   'OBSERVACION CLIENTE',
                   'SUSPENSION',
                  'CHARLA',
                  'ALISTAMIENTO',
                  'AUDITORIA',
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
