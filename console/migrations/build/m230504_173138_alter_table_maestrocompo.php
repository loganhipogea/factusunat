<?php

use yii\db\Migration;

/**
 * Class m230504_173138_alter_table_maestrocompo
 */
class m230504_173138_alter_table_maestrocompo extends \console\migrations\baseMigration
{
    public $table='{{%maestrocompo}}';
    public $campo='codfam';
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