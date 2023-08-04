<?php

class m230730_163924_alter_table_matdetreq extends \console\migrations\baseMigration
{
    public $table='{{%mat_detreq}}';
    public $campo='codal';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(4)); 
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230717_035208_alter_table_documentos cannot be reverted.\n";

        return false;
    }
    */
}
