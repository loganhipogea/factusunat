<?php

use console\migrations\baseMigration;

/**
 * Class m220801_051406_addsemanatareo
 */
class m220801_051406_addsemanatareo extends baseMigration
{
    const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_TAREODET='{{%op_tareodet}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table=static::TABLE_TAREO;
        if(!$this->existsColumn($table,'semana')){         
           $this->addColumn($table, 'semana', $this->integer(2));
        }
        if(!$this->existsColumn($table,'esferiado')){         
           $this->addColumn($table, 'esferiado', $this->char(1));
        }
        
        $table=static::TABLE_TAREODET;
        if(!$this->existsColumn($table,'semana')){         
           $this->addColumn($table, 'semana', $this->integer(2));
        }
        if(!$this->existsColumn($table,'esferiado')){         
           $this->addColumn($table, 'esferiado', $this->char(1));
        }
        if(!$this->existsColumn($table,'basico')){         
           $this->addColumn($table, 'basico', $this->decimal(9,2)->comment('Solo trabajo horas extras :  horas normales*tarifa '));
        }
       if(!$this->existsColumn($table,'dominical')){         
           $this->addColumn($table, 'dominical', $this->decimal(9,2)->comment('Compensacion dominical  el basico/6 nada mas '));
        }
       if(!$this->existsColumn($table,'adicional')){         
           $this->addColumn($table, 'adicional', $this->decimal(9,2)->comment('Total adicionales feriados y horas extras  tarifa*( horasdomingo*factor+horasextras*factor) '));
        }
       if(!$this->existsColumn($table,'esnocturno')){         
           $this->addColumn($table, 'esnocturno', $this->char(1)->comment('Si es nocturno'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table=static::TABLE_TAREO;
        if($this->existsColumn($table,'semana')){         
           $this->dropColumn($table, 'semana');
        }
        if($this->existsColumn($table,'esferiado')){         
           $this->dropColumn($table, 'esferiado');
        }
        
        $table=static::TABLE_TAREODET;
        if($this->existsColumn($table,'semana')){         
           $this->dropColumn($table, 'semana');
        }
        if($this->existsColumn($table,'esferiado')){         
           $this->dropColumn($table, 'esferiado');
        }
         if($this->existsColumn($table,'basico')){         
           $this->dropColumn($table, 'basico');
        }
        if($this->existsColumn($table,'adicional')){         
           $this->dropColumn($table, 'adicional');
        }
        if($this->existsColumn($table,'esnocturno')){         
           $this->dropColumn($table, 'esnocturno');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220801_051406_addsemanatareo cannot be reverted.\n";

        return false;
    }
    */
}
