<?php

use yii\db\Migration;

/**
 * Class m230427_005142_alter_table_transa_table
 */
class m230427_005142_alter_table_transa_table extends \console\migrations\baseMigration
{
    public $table='{{%transacciones}}';
    public $campo='exigehistorial';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(1)); 
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