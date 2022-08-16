<?php

use console\migrations\baseMigration;

/**
 * Class m220813_013151_alter_table_cccompras
 */
class m220813_013151_alter_table_cccompras extends baseMigration
{
    /**
     * {@inheritdoc}
     */
   const TABLE_COMPRAS='{{%cc_compras}}';
   const TABLE_MOVIMIENTOS='{{%cc_movimientos}}';
     public function safeUp()
    {
        $table=static::TABLE_COMPRAS;
        $tablecompras=static::TABLE_MOVIMIENTOS;
        if(!$this->existsColumn($table,'estado')){         
           $this->addColumn($table, 'estado', $this->char(2));
        }
        
        if(!$this->existsColumn($tablecompras,'estado')){         
           $this->addColumn($tablecompras, 'estado', $this->char(2));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE_COMPRAS;
        $tablecompras=static::TABLE_MOVIMIENTOS;
        if($this->existsColumn($table,'estado')){         
           $this->dropColumn($table, 'estado');
        }
        if($this->existsColumn($tablecompras,'estado')){         
           $this->dropColumn($tablecompras, 'estado');
        }
       
      
    }
  
}
