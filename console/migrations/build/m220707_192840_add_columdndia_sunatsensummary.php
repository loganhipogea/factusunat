<?php
use console\migrations\baseMigration;
class m220707_192840_add_columdndia_sunatsensummary extends baseMigration
{public $table='{{%sunat_send_sumary}}';
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
     
   }
}
