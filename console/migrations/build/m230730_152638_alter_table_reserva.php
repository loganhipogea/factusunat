<?php
class m230730_152638_alter_table_reserva extends console\migrations\baseMigration
{
    public $table='{{%mat_reservadet}}';
    public $campo='detreq_id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->integer(11)); 
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
