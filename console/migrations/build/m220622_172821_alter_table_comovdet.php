<?php

use console\migrations\baseMigration;

/**
 * Class m220622_172821_alter_table_comovdet
 */
class m220622_172821_alter_table_comovdet  extends baseMigration
{
    public $table='{{%com_ovdet}}';
    public function safeUp()
    {
        if(!$this->existsColumn($this->table, 'cant'))
        $this->addColumn($this->table,'cant',$this->decimal(8,2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       if($this->existsColumn($this->table, 'cant'))
        $this->dropColumn($this->table,'cant');
  
    }

}
