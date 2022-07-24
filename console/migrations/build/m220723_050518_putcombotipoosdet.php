<?php

use console\migrations\baseMigration;

/**
 * Class m220723_050518_putcombotipoosdet
 */
class m220723_050518_putcombotipoosdet extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
                $this->putCombo('{{%op_osdet}}', 'tipo', [
                 'OPERACION',
                  'REUNION',
                   'REPROCESO',
                    'TRABAJO GABINETE'                   
                  ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->deleteCombo('{{%op_osdet}}', 'tipo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220723_050518_putcombotipoosdet cannot be reverted.\n";

        return false;
    }
    */
}
