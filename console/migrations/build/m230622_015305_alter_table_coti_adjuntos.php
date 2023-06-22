<?php

use yii\db\Migration;

/**
 * Class m230622_015305_alter_table_coti_adjuntos
 */
class m230622_015305_alter_table_coti_adjuntos extends console\migrations\baseMigration
{ 
    public $table='{{%com_cotiadjuntos}}';
    public $campo='interno';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(3)); 
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
        
        
    }
}