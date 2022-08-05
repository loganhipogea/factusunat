<?php

use console\migrations\baseMigration;

/**
 * Class m220804_211445_alterccmovimiento
 */
class m220804_211445_alterccmovimiento extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const TABLE='{{%cc_compras}}';
    public function safeUp()
    {
            $table=static::TABLE;
        if(!$this->existsColumn($table,'movimiento_id')){         
           $this->addColumn($table, 'movimiento_id', $this->integer(11));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'movimiento_id')){         
           $this->dropColumn($table, 'movimiento_id');
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
