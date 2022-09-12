<?php

use yii\db\Migration;

/**
 * Class m220831_030452_alter_table_comprascomprobante
 */
class m220831_030452_alter_table_comprascomprobante extends \console\migrations\baseMigration
{ public $table='{{%cc_compras}}';
    public $campo='prefijo';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
        }
        
        if(!$this->existsColumn($this->table,'serie')){  
            $this->addColumn($this->table,'serie', $this->string(4));
        } 
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(10));
        } 
       if($this->existsColumn($this->table,'serie')){  
            $this->dropColumn($this->table,'serie');
        } 
       
   }
}
