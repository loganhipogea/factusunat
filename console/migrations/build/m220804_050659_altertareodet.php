<?php

use console\migrations\baseMigration;

/**
 * Class m220804_050659_altertareodet
 */
class m220804_050659_altertareodet extends baseMigration
{ 
    public $table='{{%op_tareodet}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {

        if(!$this->existsColumn($this->table,'anio')){         
           $this->addColumn($this->table, 'anio', $this->char(4));
        }
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        if($this->existsColumn($this->table,'anio')){         
           $this->dropColumn($this->table, 'anio');
        }
       
       
    }
  
}
