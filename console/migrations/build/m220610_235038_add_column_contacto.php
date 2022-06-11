<?php

use console\migrations\baseMigration;

/**
 * Class m220610_235038_add_column_contacto
 */
class m220610_235038_add_column_contacto extends baseMigration

{
     public $table='{{%contactos}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
   if(!$this->existsColumn($this->table,'cargo')){  
        $this->addColumn($this->table, 'cargo', $this->string(40));
     }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       if($this->existsColumn($this->table,'cargo')){  
        $this->dropColumn($this->table, 'cargo');
         }
                }
}
