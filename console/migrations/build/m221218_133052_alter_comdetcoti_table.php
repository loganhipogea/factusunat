<?php
use console\migrations\migrationMenu;
use console\migrations\baseMigration;
class m221218_133052_alter_comdetcoti_table extends baseMigration
{
    public $table='{{%com_detcoti}}';
    public $campo='punitcalculado';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(10,4));
        }
        
        $this->campo='cotigrupo_id';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
         //migrationMenu::insertOption('Sustancias', '/masters/basico/index-sustancia','Materiales','snowflake-o');
        $this->campo='coticeco_id';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
        
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        $this->campo='cotigrupo_id';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       $this->campo='coticeco_id';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
      // migrationMenu::deleteOption('Sustancias', '/masters/basico/index-sustancia');
       
    }
       
} 