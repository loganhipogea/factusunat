<?php

use yii\db\Migration;

/**
 * Class m230421_234553_alter_table_ransadocs
 */
class m230421_234553_alter_table_ransadocs extends console\migrations\baseMigration
{
   
    public $table='{{%transacciones}}';
    public $campo='exigirvalidacion';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(3)->append($this->collateColumn())); 
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
    