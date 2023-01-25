<?php

use yii\db\Migration;
use common\helpers\h;
/**
 * Class m230125_212114_insertparametro
 */
class m230125_212114_insertparametro extends Migration
{/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       h::getIfNotPutSetting('com','tenorinf_coti','Cualquier observacion o cambio en las condiciones de la presente oferta por favor nodudar en contactarnos a la brevedad');
      h::settings()->invalidateCache();
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        h::settings()->remove('com','tenorinf_coti');
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
