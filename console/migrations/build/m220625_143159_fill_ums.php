<?php
use console\migrations\baseMigration;

/**
 * Class m220625_143159_fill_ums
 */
class m220625_143159_fill_ums extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%ums}}',
             ['codum','desum'],[
                                ['NIU','UN'],
                                ['KGM','KG'],
                                ['MTR','M'],
                                ['GRM','GR'],
                                ['CMT','CM'],
                                ]
                     )->execute();
         
         
         
           /*$this->putCombo('{{%ums}}','codum', [
               'NIU'=>'UN',
                'KGM'=>'KG',
               'MTR'=>'M',
                'GRM'=>'GR',
               'CMT'=>'CM',
           ]);*/
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
        echo "m220625_143159_fill_ums cannot be reverted.\n";

        return false;
    }
    */
}
