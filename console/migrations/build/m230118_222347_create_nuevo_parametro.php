<?php

use yii\db\Migration;
use common\helpers\h;
/**
 * Class m230118_222347_create_nuevo_parametro
 */
class m230118_222347_create_nuevo_parametro extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         h::getIfNotPutSetting('op','um_hora','HH');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230118_222347_create_nuevo_parametro cannot be reverted.\n";

        return false;
    }
    */
}
