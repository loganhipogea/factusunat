<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%opdocumentos}}`.
 */
class m220721_120833_create_opdocumentos_table extends baseMigration
{
     const TABLE='{{%op_documentos}}';
   // const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';
   const TABLE_DOCUMENTOS='{{%documentos}}';
  public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
           'proc_id'=>$this->integer(11)->notNull(),
           'os_id'=>$this->integer(11)->notNull(),
           'detos_id'=>$this->integer(11)->notNull(),
           'descripcion'=>$this->string(40)->append($this->collateColumn()),
           'detalles'=>$this->text()->append($this->collateColumn()),
            'user_id'=>$this->integer(4)->notNull(),
           'codocu'=>$this->char(3)->notNull(),
           'role'=>$this->string(90)->append($this->collateColumn()),  
            ],
           $this->collateTable());
        $this->paramsFk=[
            self::TABLE,
            'codocu',
           static::TABLE_DOCUMENTOS,
            'codocu'
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
