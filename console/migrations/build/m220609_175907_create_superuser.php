<?php
use console\migrations\baseMigration;
use common\helpers\h;
use common\models\User;
use mdm\admin\components\UserStatus;
class m220609_175907_create_superuser extends baseMigration
{
    private $username='admin';
    private $email='hipogea57@hotmail.com';
    private $pwd='12345678';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*Hacemos el superusurio */
        if(!h::userNameExists($this->username)){
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = UserStatus::ACTIVE; 
            $user->setPassword($this->pwd);
            $user->generateAuthKey();
            $user->save();
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     if(h::userNameExists($this->username)){
      User::deleteAll(['username'=>$this->username]);
     }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220609_175907_create_superuser cannot be reverted.\n";

        return false;
    }
    */
}
