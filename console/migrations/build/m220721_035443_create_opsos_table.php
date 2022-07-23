<?php
use console\migrations\baseMigration;
class m220721_035443_create_opsos_table extends baseMigration
{
    
    const TABLE='{{%op_os}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'item')){         
           $this->addColumn($table, 'item', $this->char(3));
        }
        if($this->existsColumn($table,'numero')){         
           $this->alterColumn($table,'numero', $this->string(10));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'item')){         
           $this->dropColumn($table, 'item');
        }
        if($this->existsColumn($table,'numero')){         
           $this->alterColumn($table,'numero', $this->string(9));
        }
       
    }
   
}
