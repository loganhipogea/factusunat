<?php
use console\migrations\baseMigration;
class m220626_210738_alter_comfactu_table extends baseMigration
{
    public $table='{{%com_factura}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'hemision')){  
            $this->addColumn($this->table, 'hemision', $this->string(11));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'hemision')){  
            $this->dropColumn($this->table, 'hemision');
        }
       
   }
}
