<?php

use console\migrations\baseMigration;
class m220805_051603_altercontactos extends baseMigration
{
   const TABLE='{{%contactos}}';
    public function safeUp()
    {
            $table=static::TABLE;
        if($this->existsColumn($table,'mail')){         
           $this->alterColumn($table, 'mail', $this->string(120));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
           $table=static::TABLE;
        if($this->existsColumn($table,'mail')){         
           $this->alterColumn($table, 'mail', $this->string(25));
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220804_211445_alterccmovimiento cannot be reverted.\n";

        return false;
    }
    */
}
