<?php
use console\migrations\baseMigration;
class m220625_170050_alter_ov_table extends baseMigration
{
   public $table='{{%com_ov}}';
    public function safeUp()
    { 
       if(!$this->existsColumn($this->table, 'femision'))
        $this->addColumn($this->table, 'femision', $this->char(10));
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
      {      
            if($this->existsColumn($this->table, 'femision'))
            $this->dropColumn($this->table, 'femision');
                  //$this->dropColumn($this->table, 'descripcion');
       }
}

    

    