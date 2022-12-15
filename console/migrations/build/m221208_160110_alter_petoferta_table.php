<?php

use yii\db\Migration;

/**
 * Class m221208_160110_alter_petoferta_table
 */
class m221208_160110_alter_petoferta_table extends \console\migrations\baseMigration
{ 
    public $table='{{%mat_petoferta}}';
    public $campo='id_relacionado';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         
        
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
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
