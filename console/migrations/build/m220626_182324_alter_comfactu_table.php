<?php
use console\migrations\baseMigration;

/**
 * Class m220619_002604_add_columns_stock
 */
class m220626_182324_alter_comfactu_table extends baseMigration
{public $table='{{%com_factura}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'nombre_cliente')){  
            $this->addColumn($this->table, 'nombre_cliente', $this->string(40));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'nombre_cliente')){  
            $this->dropColumn($this->table, 'nombre_cliente');
        }
       
   }
}
