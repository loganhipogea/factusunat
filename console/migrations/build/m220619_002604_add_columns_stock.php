<?php
use console\migrations\baseMigration;

/**
 * Class m220619_002604_add_columns_stock
 */
class m220619_002604_add_columns_stock extends baseMigration
{ public $table='{{%stock}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'pventa')){  
            $this->addColumn($this->table, 'pventa', $this->decimal(8,2));
        }
        if(!$this->existsColumn($this->table,'ceconomica')){  
            $this->addColumn($this->table, 'ceconomica', $this->decimal(8,3));
        }
        if(!$this->existsColumn($this->table,'creorden')){  
            $this->addColumn($this->table, 'creorden', $this->decimal(8,3));
        }
         if(!$this->existsColumn($this->table,'cminima')){  
            $this->addColumn($this->table, 'cminima', $this->decimal(8,3));
        }
        if(!$this->existsColumn($this->table,'clas_abc')){  
            $this->addColumn($this->table, 'clas_abc', $this->char(1));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'pventa')){  
            $this->dropColumn($this->table, 'pventa');
        }
        if($this->existsColumn($this->table,'ceconomica')){  
            $this->dropColumn($this->table, 'ceconomica');
        }
        if($this->existsColumn($this->table,'creorden')){  
            $this->dropColumn($this->table, 'creorden');
        }
         if($this->existsColumn($this->table,'cminima')){  
            $this->dropColumn($this->table, 'cminima');
        }
        if($this->existsColumn($this->table,'clas_abc')){  
            $this->dropColumn($this->table, 'clas_abc');
        }  
     
   }
}
