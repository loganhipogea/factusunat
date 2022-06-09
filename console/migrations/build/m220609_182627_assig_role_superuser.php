<?php
use console\migrations\baseMigration;
//use common\helpers\h;
//use common\models\User;
use backend\components\Installer;
//use mdm\admin\components\UserStatus;
class m220609_182627_assig_role_superuser extends baseMigration
{
   public $username='admin';
    public function safeUp()
    {
        Installer::createBasicRole($this->username);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220609_182627_assig_role_superuser cannot be reverted.\n";

        return false;
    }
    */
}
