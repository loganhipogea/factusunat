<?php

use yii\db\Migration;

/**
 * Class m221127_150153_alter_table_petoferta
 */
class m221127_150153_alter_table_petoferta  extends \console\migrations\baseMigration
{ 
    public $table='{{%mat_petoferta}}';
    public $campo='igv';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         
        
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->char(1));
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
