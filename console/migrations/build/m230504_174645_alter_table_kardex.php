<?php

use yii\db\Migration;

/**
 * Class m230504_174645_alter_table_kardex
 */
class m230504_174645_alter_table_kardex extends \console\migrations\baseMigration
{
    public $table='{{%mat_kardex}}';
    public $campo='valor';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->decimal(10,4)); 
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