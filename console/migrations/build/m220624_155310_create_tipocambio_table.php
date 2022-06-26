<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%tipocambio}}`.
 */
class m220624_155310_create_tipocambio_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%tipocambio}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'fecha'=>$this->char(10)->notNull()->append($this->collateColumn()),
            'codmon'=>$this->string(4)->notNull()->append($this->collateColumn()),
            'compra'=>$this->decimal(5,2)->notNull(),
            'venta'=>$this->decimal(5,2)->notNull(), 
            'ultima'=>$this->char(19)->append($this->collateColumn()), 
        ]);
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
