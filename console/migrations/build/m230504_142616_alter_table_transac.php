<?php

use yii\db\Migration;

/**
 * Class m230504_142616_alter_table_transac
 */
class m230504_142616_alter_table_transac extends \console\migrations\baseMigration
{
    public $table='{{%transacciones}}';
    public $campo='es_servicio';
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