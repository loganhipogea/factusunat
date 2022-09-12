<?php

use yii\db\Migration;

/**
 * Class m220831_153622_alter_table_comprascomprobante
 */
class m220831_153622_alter_table_comprascomprobante extends console\migrations\baseMigration
{  
    public $table='{{%cc_compras}}';
    public $campo='obs';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        
        if(!$this->existsColumn($this->table,'obs')){  
            $this->addColumn($this->table,'obs', $this->text());
        } 
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
       if($this->existsColumn($this->table,'obs')){  
            $this->dropColumn($this->table,'obs');
        } 
       
   }
}
