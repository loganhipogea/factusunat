<?php
use console\migrations\baseMigration;
class m220704_144020_add_column_doccleinte_factura extends baseMigration
{
  public $table='{{%com_factura}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'sunat_tipdoccli')){  
            $this->addColumn($this->table, 'sunat_tipdoccli', $this->string(2));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'sunat_tipdoccli')){  
            $this->dropColumn($this->table, 'sunat_tipdoccli');
        }
        
     
   }
}
