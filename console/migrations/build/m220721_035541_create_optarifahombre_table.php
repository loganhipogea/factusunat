<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%optarifahombre}}`.
 */
class m220721_035541_create_optarifahombre_table extends baseMigration
{
    const TABLE='{{%op_tarifa_hombre}}';
  const TABLE_TARIFAS='{{%op_planestarifa}}';
  const TABLE_TRABAJADORES='{{%trabajadores}}';
  public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
           'tarifa_id'=>$this->integer(11)->notNull(),
           'codtra'=>$this->char(6)->append($this->collateColumn()),
            'costohora'=>$this->decimal(6,2),
           
           
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
            'tarifa_id',
             static::TABLE_TARIFAS,
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
