<?php
use console\migrations\migrationMenu;
use console\migrations\baseMigration;
class m221216_135713_alter_table_cotigroup extends baseMigration
{
    public $table='{{%com_cotigrupos}}';
    public $campo='total';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->decimal(12,3));
        }
        $this->campo='item';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(6));
        }
        
        $this->campo='coti_id';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
         //migrationMenu::insertOption('Sustancias', '/masters/basico/index-sustancia','Materiales','snowflake-o');
       
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       $this->campo='item';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       $this->campo='coti_id';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
      // migrationMenu::deleteOption('Sustancias', '/masters/basico/index-sustancia');
       
    }
       
} 