<?php

use yii\db\Migration;
USE console\migrations\migrationMenu;
/**
 * Class m220812_192256_create_opcionmenu_users
 */
class m220812_192256_create_opcionmenu_users extends \console\migrations\baseMigration
{
/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        migrationMenu::insertOption('Usuarios', '/profile/manage-users','User','users');
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         migrationMenu::deleteOption('Usuarios', '/profile/manage-users','User');
         
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220812_192256_create_opcionmenu_users cannot be reverted.\n";

        return false;
    }
    */
}
