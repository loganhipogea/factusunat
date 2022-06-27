<?php
use console\migrations\baseMigration;
class m220626_012531_alter_ov_table  extends baseMigration
{
     public $table='{{%com_ov}}';     
    public function safeUp()
    {
        
        if(!$this->existsColumn($this->table,'codestado')){  
            $this->addColumn($this->table,'codestado', $this->char(2));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,'codestado');
        }
     
   }
}
