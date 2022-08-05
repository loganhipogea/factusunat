<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%ccgastos}}`.
 */
class m220804_214530_create_ccgastos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%cc_gastos}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'comprobante_id' => $this->integer(11),  
            'proc_id' => $this->integer(11), 
            'os_id' => $this->integer(11), 
            'detos_id' => $this->integer(11),
            'ceco_id' => $this->integer(11),
             'monto' => $this->decimal(12,3),  
            'monto_usd' => $this->decimal(12,3), 
             'user_id' => $this->integer(4),  
              'tipo' => $this->char(1), 
                'detalle' => $this->text(),  
        ],
           $this->collateTable());
      }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
