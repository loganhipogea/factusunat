<?php



/**
 * Class m230306_024240_alter_table_bancos
 */
class m230306_024240_alter_table_bancos extends console\migrations\baseMigration
{
   
    public $table='{{%bancos}}';
    public $campo='tipo';/**
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->char(2)->append($this->collateColumn())); 
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
        echo "m230306_024240_alter_table_bancos cannot be reverted.\n";

        return false;
    }
    */
}
