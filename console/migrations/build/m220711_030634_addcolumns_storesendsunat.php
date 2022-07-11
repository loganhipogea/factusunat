<?php
use console\migrations\baseMigration;
class m220711_030634_addcolumns_storesendsunat extends baseMigration
{public $table='{{%sunat_sends}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'ndia')){  
            $this->addColumn($this->table, 'ndia',
                    $this->char(3)->comment("el numero de dia del año")
                    );
        }
        if(!$this->existsColumn($this->table,'numero')){  
            $this->addColumn($this->table, 'numero',
                    $this->string(9)->comment("eNumero correlativo")
                    );
        }
        if(!$this->existsColumn($this->table,'caja_id')){  
            $this->addColumn($this->table, 'caja_id',
                    $this->integer(11)->comment("Relacion con la caja diaria ")
                    );
        }
        if(!$this->existsColumn($this->table,'ticket')){  
            $this->addColumn($this->table, 'ticket',
                    $this->string(100)->comment("numero de ticket")
                    );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'ndia')){  
            $this->dropColumn($this->table, 'ndia');
        }
        if($this->existsColumn($this->table,'numero')){  
            $this->dropColumn($this->table, 'numero');
        }
        if($this->existsColumn($this->table,'ticket')){  
            $this->dropColumn($this->table, 'ticket');
        }
        if($this->existsColumn($this->table,'caja_id')){  
            $this->dropColumn($this->table, 'caja_id');
        }
     
   }
}
