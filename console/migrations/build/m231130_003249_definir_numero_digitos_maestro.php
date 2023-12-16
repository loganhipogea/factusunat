<?php

use console\migrations\baseMigration;
use common\helpers\h;
/**
 * Class m231130_003249_definir_numero_digitos_maestro
 */
class m231130_003249_definir_numero_digitos_maestro extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        h::getIfNotPutSetting('general', 'n_digitos_materiales', 14);
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
        echo "m231130_003249_definir_numero_digitos_maestro cannot be reverted.\n";

        return false;
    }
    */
}
