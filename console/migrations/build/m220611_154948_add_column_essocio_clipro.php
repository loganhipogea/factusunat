<?php
use console\migrations\baseMigration;
class m220611_154948_add_column_essocio_clipro extends baseMigration

{
     public $table='{{%clipro}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
   if(!$this->existsColumn($this->table,'socio')){  
        $this->addColumn($this->table, 'socio', $this->char(1));
     }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       if($this->existsColumn($this->table,'socio')){  
        $this->dropColumn($this->table, 'socio');
         }
                }
}
