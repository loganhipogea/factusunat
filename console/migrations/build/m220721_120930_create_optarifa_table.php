<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%optarifa}}`.
 */
class m220721_120930_create_optarifa_table extends baseMigration
{
    
    const TABLE='{{%op_tarifa_hombre}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'activo')){         
           $this->addColumn($table, 'activo', $this->char(1));
        }
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'activo')){         
           $this->dropColumn($table, 'activo');
        }
        
       
    }
   
}
