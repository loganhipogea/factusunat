<?php

use yii\db\Migration;
use common\helpers\h;
/**
 * Class m220714_011956_addparamserieregex
 */
class m220714_011956_addparamserieregex extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       h::getIfNotPutSetting('com','formatoSeries','/[A-Z]{2}[0-9]{1}[1-9]$/');
      h::settings()->invalidateCache();
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        h::settings()->remove('com','formatoSeries');
        h::settings()->invalidateCache();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220714_011956_addparamserieregex cannot be reverted.\n";

        return false;
    }
    */
}
