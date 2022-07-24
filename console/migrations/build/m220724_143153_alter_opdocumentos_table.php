<?php

use console\migrations\baseMigration;

/**
 * Class m220724_143153_alter_opdocumentos_table
 */
class m220724_143153_alter_opdocumentos_table extends baseMigration
{ 
    public $table='{{%op_documentos}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {

        if(!$this->existsColumn($this->table,'cuando')){         
           $this->addColumn($this->table, 'cuando', $this->string(19));
        }
        if(!$this->existsColumn($this->table,'version')){         
           $this->addColumn($this->table, 'version', $this->decimal(4,2));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        if($this->existsColumn($this->table,'cuando')){         
           $this->dropColumn($this->table, 'cuando');
        }
        if($this->existsColumn($this->table,'version')){         
           $this->dropColumn($this->table, 'version');
        }
       
    }
  
}
