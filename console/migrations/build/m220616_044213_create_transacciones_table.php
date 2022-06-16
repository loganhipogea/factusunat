<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%transacciones}}`.
 */
class m220616_044213_create_transacciones_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%transacciones}}';    
   
 const NAME_TABLE_CENTROS='{{%centros}}';
 //const NAME_TABLE_PARAMETROS='{{%parametros}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       
if(!$this->existsTable($this->table)) {
    $this->createTable($this->table, [
       'codtrans'=>$this->char(3)->notNull()->append($this->collateColumn()),
       'descripcion' => $this->string(40)->notNull()->append($this->collateColumn()),
       'signo'=>$this->integer(1)->notNull(),
        'detalles'=>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
         
    
         $this->addPrimaryKey('pk'.$this->generateNameFk($this->table),$this->table, 'codtrans');
         /* $this->addForeignKey($this->generateNameFk($table), static::NAME_TABLE,
              'codparam', static::NAME_TABLE_PARAMETROS,'codparam');*/
               }
  
           
}

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {   
       if ($this->existsTable($this->table)) {
            $this->dropTable($this->table);
        }

    }
}


