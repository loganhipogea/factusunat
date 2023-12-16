<?php


/**
 * Class m231121_181438_alter_table_detgui
 */
class m231121_181438_alter_table_detgui extends \console\migrations\baseMigration
{
    public $table='{{%mat_guia}}';
    public $campo='codcencli';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->string(5)); 
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
