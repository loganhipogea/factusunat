<?php
use console\migrations\baseMigration;
class m220804_184451_altercuentas extends baseMigration
{
    /**
     * {@inheritdoc}
     */
   const TABLE='{{%cuentas}}';
     public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'socio')){         
           $this->addColumn($table, 'socio', $this->char(1));
        }
        if(!$this->existsColumn($table,'indicaciones')){         
           $this->addColumn($table, 'indicaciones' , $this->text());
        }
       if(!$this->existsColumn($table,'indicaciones2')){         
           $this->addColumn($table, 'indicaciones2' , $this->text());
        }
        if(!$this->existsColumn($table,'activa')){         
           $this->addColumn($table, 'activa' , $this->char(1));
        }
        if(!$this->existsColumn($table,'saldo')){         
           $this->addColumn($table, 'saldo' , $this->decimal(14,4));
        }
        if(!$this->existsColumn($table,'fecult')){         
           $this->addColumn($table, 'fecult' , $this->char(10));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if(!$this->existsColumn($table,'socio')){         
           $this->dropColumn($table, 'tipo');
        }
        if(!$this->existsColumn($table,'indicaciones')){         
           $this->dropColumn($table, 'indicaciones');
        }
       if(!$this->existsColumn($table,'indicaciones2')){         
           $this->dropColumn($table, 'indicaciones2');
        }
        if(!$this->existsColumn($table,'activa')){         
           $this->dropColumn($table, 'activa');
        }
        if(!$this->existsColumn($table,'saldo')){         
           $this->dropColumn($table, 'saldo');
        }
        if(!$this->existsColumn($table,'fecult')){         
           $this->dropColumn($table, 'fecult');
        }
      
    }
  
}
