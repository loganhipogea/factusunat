<?php

use console\migrations\baseMigration;

/**
 * Class m220610_161153_add_column_alias_to_clipro
 */
class m220610_161153_add_column_alias_to_clipro extends baseMigration

{
     public $table='{{%clipro}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
   if(!$this->existsColumn($this->table,'alias')){  
        $this->addColumn($this->table, 'alias', $this->string(40));
     }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       if($this->existsColumn($this->table,'alias')){  
        $this->dropColumn($this->table, 'alias');
         }
                }
}
