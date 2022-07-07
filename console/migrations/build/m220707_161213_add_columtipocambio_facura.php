<?php
use console\migrations\baseMigration;
class m220707_161213_add_columtipocambio_facura extends baseMigration
{public $table='{{%com_factura}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'cambio')){  
            $this->addColumn($this->table, 'cambio', $this->decimal(6,2));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'cambio')){  
            $this->dropColumn($this->table, 'cambio');
        }
        
     
   }
}
