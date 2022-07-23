<?php

use console\migrations\baseMigration;
class m220722_130710_create_matstock extends baseMigration
{
   const TABLE='{{%mat_stock}}';
   const TABLE_MATERIALES='{{%maestrocompo}}';
   public function safeUp()
    {
    $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
              'codart'=>$this->string(14)->unique()->notNull()->append($this->collateColumn()),
            'cant' =>$this->decimal(8,3),
            'um' =>  $this->string(4)->append($this->collateColumn()),
           'ubicacion' =>$this->string(14)->append($this->collateColumn()),
            'cantres' =>$this->decimal(8,3),
             'codal' =>  $this->string(4)->append($this->collateColumn()),
            'valor' =>$this->decimal(10,3),
           'lastmov'=> $this->string(10)->append($this->collateColumn()),
         
            ],
           $this->collateTable());
       
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
