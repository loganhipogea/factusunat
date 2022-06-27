<?php
use console\migrations\baseMigration;
class m220626_202413_alter_comfactudet_table extends  baseMigration
{
    public $table='{{%com_factudet}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'sunat_tipodoc')){  
            $this->addColumn($this->table, 'sunat_tipodoc', $this->char(2));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         if($this->existsColumn($this->table,'sunat_tipodoc')){  
            $this->dropColumn($this->table, 'sunat_tipodoc');
        }
       
   }
}
