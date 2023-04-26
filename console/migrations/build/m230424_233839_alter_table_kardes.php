<?php

use yii\db\Migration;

/**
 * Class m230424_233839_alter_table_kardes
 */
class m230424_233839_alter_table_kardes  extends console\migrations\baseMigration
{
   
    public $table='{{%mat_kardex}}';
    public $campo='codart';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->string(14)->append($this->collateColumn())); 
        }
        $this->campo='codal';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(4)->append($this->collateColumn())); 
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->campo='codal';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
         $this->campo='codart';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
        
    }
}
    