<?php

use yii\db\Migration;

/**
 * Class m230225_183922_altertableenvios
 */
class m230225_183922_altertableenvios extends \console\migrations\baseMigration
{
    
     public $table='{{%com_cotienvios}}';
    public $campo='cuando';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         
        
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->string(19));
        } 
        $this->table='{{%com_cotiversiones}}';
        $this->campo='lastlog_id';
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(20));
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
       $this->table='{{%com_cotiversiones}}';
        $this->campo='lastlog_id';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
        } 
   }
}
