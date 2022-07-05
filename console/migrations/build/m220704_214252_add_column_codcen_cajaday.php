<?php
use console\migrations\baseMigration;
class m220704_214252_add_column_codcen_cajaday extends baseMigration
{
  public $table='{{%com_cajadia}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'codcen')){  
            $this->addColumn($this->table, 'codcen', $this->string(5));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'codcen')){  
            $this->dropColumn($this->table, 'codcen');
        }
        
     
   }
}
