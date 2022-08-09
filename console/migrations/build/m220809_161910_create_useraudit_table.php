<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%useraudit}}`.
 */
class m220809_161910_create_useraudit_table extends baseMigration
{
   public $table='{{%useraudit}}';
  const NAME_TABLE_USER='{{%user}}';
  // const NAME_TABLE_MAESTRO='{{%maestrocompo}}';
    public function safeUp()
    {
       
if (!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
             'id'=>$this->primaryKey(),
            'user_id'=>$this->integer(11),
            'when'=>$this->char(19)->append($this->collateColumn()),
            'ip'=>$this->string(19)->append($this->collateColumn()),
            'action'=>$this->string(6)->append($this->collateColumn()),
             ],$this->collateTable());
         
     $this->paramsFk=[
         $this->table,
         'user_id',
         self::NAME_TABLE_USER,
         'id'
     ]; 
}
    
    }

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       if ($this->existsTable($this->table)) {
            $this->dropTable($this->table);
        }

    }
}