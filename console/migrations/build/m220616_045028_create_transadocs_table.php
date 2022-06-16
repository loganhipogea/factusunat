<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%transadocs}}`.
 */
class m220616_045028_create_transadocs_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%transadocs}}'; 
    CONST NAME_TABLE_TRANSA='{{%transacciones}}';
    CONST NAME_TABLE_DOCUS='{{%documentos}}';
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
         $this->createTable($this->table, [
            'id' => $this->primaryKey(),
             'codtrans'=>$this->char(3)->notNull()->append($this->collateColumn()),
             'codocu'=>$this->char(3)->notNull()->append($this->collateColumn()),
             'tipodoc'=>$this->char(2)->notNull()->append($this->collateColumn()),
             'codestado'=>$this->char(2)->notNull()->append($this->collateColumn()),
             
             
        ],$this->collateTable());
         
          $this->paramsFk=[
            $this->table,
            'codtrans',
            self::NAME_TABLE_TRANSA,
            'codtrans'
                ];
          
         $this->addFk();
           $this->paramsFk=[
            $this->table,
            'codocu',
            self::NAME_TABLE_DOCUS,
            'codocu'
                ];
         $this->addFk();
         
        
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
