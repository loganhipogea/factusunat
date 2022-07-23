<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%matvale}}`.
 */
class m220722_131000_create_matvale_table extends baseMigration
{
    const TABLE='{{%mat_vale}}';
   const TABLE_CLIPRO='{{%clipro}}';
   public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
            'numero' => $this->string(10)->notNull(),
            'fecha' =>  $this->char(10)->append($this->collateColumn()),
            //'fechasol' =>  $this->char(10)->append($this->collateColumn()),
            'codpro' => $this->string(10)->notNull()->append($this->collateColumn()),
            'codmov' => $this->char(3)->notNull()->append($this->collateColumn()),
           'descripcion' =>  $this->string(40)->append($this->collateColumn()),
            'texto' =>  $this->text()->append($this->collateColumn()),
            'codest' =>  $this->char(3)->append($this->collateColumn()),
            ],
           $this->collateTable());
       
       $this->paramsFk=[
            self::TABLE,
            'codpro',
           '{{%clipro}}',
            'codpro'
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
