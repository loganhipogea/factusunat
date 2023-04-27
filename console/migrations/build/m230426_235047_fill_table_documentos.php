<?php
use frontend\modules\mat\models\MatVale;
use common\models\masters\Documentos;

class m230426_235047_fill_table_documentos extends \console\migrations\baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
     
      Documentos::updateAll(['modelo'=> '\\'.MatVale::className()],['codocu'=>'104']);
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
        echo "m230426_235047_fill_table_documentos cannot be reverted.\n";

        return false;
    }
    */
}
