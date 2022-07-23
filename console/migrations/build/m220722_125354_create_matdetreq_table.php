<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%matdetreq}}`.
 */
class m220722_125354_create_matdetreq_table extends baseMigration
{
    const TABLE='{{%mat_detreq}}';
   const TABLE_REQ='{{%mat_req}}';
   public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
            'req_id'=>$this->integer(11),
            'item' =>$this->char(4)->append($this->collateColumn()),
            'codart' =>$this->string(14)->append($this->collateColumn()),
           'descripcion' =>$this->string(40)->append($this->collateColumn()),
           'cant' =>$this->decimal(8,3),
            'um' =>  $this->string(4)->append($this->collateColumn()),
           'imptacion' =>  $this->string(14)->append($this->collateColumn()),
           'tipim' =>  $this->char(1)->append($this->collateColumn()),
            'texto' =>  $this->text()->append($this->collateColumn()),
            'activo' =>$this->char(1)->append($this->collateColumn()),
         
            ],
           $this->collateTable());
        $this->paramsFk=[
            self::TABLE,
            'req_id',
           static::TABLE_REQ,
            'id'
                    ];
            $this->addFk();
            
           $this->paramsFk=[
            self::TABLE,
            'codart',
           '{{%maestrocompo}}',
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
