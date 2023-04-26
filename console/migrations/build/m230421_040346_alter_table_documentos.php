<?php

use yii\db\Migration;

/**
 * Class m230421_040346_alter_table_documentos
 */
class m230421_040346_alter_table_documentos extends \console\migrations\baseMigration
{
    
    public $table='{{%documentos}}';
    public $campo='modelo';/**
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->string(256)->append($this->collateColumn())); 
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
        echo "m230421_040346_alter_table_documentos cannot be reverted.\n";

        return false;
    }
    */
}
