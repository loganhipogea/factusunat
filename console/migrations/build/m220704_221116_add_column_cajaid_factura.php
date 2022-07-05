<?php
use console\migrations\baseMigration;
class m220704_221116_add_column_cajaid_factura extends baseMigration
{public $table='{{%com_factura}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'caja_id')){  
            $this->addColumn($this->table, 'caja_id', $this->integer(11));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'caja_id')){  
            $this->dropColumn($this->table, 'caja_id');
        }
        
     
   }
}
