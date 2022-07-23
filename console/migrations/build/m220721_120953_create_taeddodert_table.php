<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%taeddodert}}`.
 */
class m220721_120953_create_taeddodert_table extends baseMigration
{
    
    const TABLE='{{%op_tareodet}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'estado')){         
           $this->addColumn($table, 'estado', $this->char(2));
        }
        if(!$this->existsColumn($table,'hextras')){         
           $this->addColumn($table, 'hextras', $this->decimal(5,2));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'estado')){         
           $this->dropColumn($table, 'estado');
        }
        if($this->existsColumn($table,'hextras')){         
           $this->dropColumn($table, 'hextras');
        }
        
       
    }
   
}
