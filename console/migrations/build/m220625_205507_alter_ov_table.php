<?php
use console\migrations\baseMigration;
class m220625_205507_alter_ov_table  extends baseMigration
{
   public $table='{{%com_ov}}';
    public function safeUp()
    { 
       if($this->existsColumn($this->table, 'tipopago'))
        $this->alterColumn($this->table, 'tipopago', $this->char(2));
       if($this->existsColumn($this->table, 'tipodoc'))
        $this->alterColumn($this->table, 'tipodoc', $this->char(2));
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
      {      
       if($this->existsColumn($this->table, 'tipopago'))
        $this->alterColumn($this->table, 'tipopago', $this->char(3));
       if($this->existsColumn($this->table, 'tipodoc'))
        $this->alterColumn($this->table, 'tipodoc', $this->char(3));
       }
}

    