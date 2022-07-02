<?php
use console\migrations\baseMigration;
class m220701_215508_add_column_flag_sunat_factura extends baseMigration
{ public $table='{{%com_factura}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'flag_sunat')){  
            $this->addColumn($this->table, 'flag_sunat', $this->integer(1));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'flag_sunat')){  
            $this->dropColumn($this->table, 'flag_sunat');
        }
        
     
   }
}
