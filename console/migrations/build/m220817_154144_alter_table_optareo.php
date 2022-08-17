<?php

use console\migrations\baseMigration;

/**
 * Class m220817_154144_alter_table_optareo
 */
class m220817_154144_alter_table_optareo extends baseMigration
{
     /**
     * {@inheritdoc}
     */
   const TABLE_COMPRAS='{{%op_tareo}}';
  // const TABLE_MOVIMIENTOS='{{%cc_movimientos}}';
     public function safeUp()
    {
        $table=static::TABLE_COMPRAS;
        
        if($this->existsColumn($table,'os_id')){
           
           $this->dropColumn($table, 'os_id');
            $this->addColumn($table, 'os_id', $this->integer(11));
        }
        if($this->existsColumn($table,'detos_id')){         
           $this->dropColumn($table, 'detos_id');
            $this->addColumn($table, 'detos_id', $this->integer(11));
        }
        
        
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE_COMPRAS;
       if($this->existsColumn($table,'os_id')){ 
            $this->dropColumn($table, 'os_id');
           $this->addColumn($table, 'os_id', $this->integer(11)->notNull());
           
        }
      if($this->existsColumn($table,'detos_id')){    
           $this->dropColumn($table, 'detos_id');
           $this->addColumn($table, 'detos_id', $this->integer(11)->notNull());
        }
    }
  
}
