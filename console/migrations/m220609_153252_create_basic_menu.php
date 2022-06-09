<?php

use yii\db\Migration;

/**
 * Class m220609_153252_create_basic_menu
 */
class m220609_153252_create_basic_menu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220609_153252_create_basic_menu cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220609_153252_create_basic_menu cannot be reverted.\n";

        return false;
    }
    */
}
