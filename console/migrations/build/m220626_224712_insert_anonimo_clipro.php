<?php
use console\migrations\baseMigration;
use common\helpers\h;
use common\models\masters\Clipro;
class m220626_224712_insert_anonimo_clipro extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $att=[
            'rucpro'=>h::getIfNotPutSetting('general','DNI_anonimo', 'XXX'),
            'despro'=>h::getIfNotPutSetting('general','nombre_anonimo', 'ANONIMUS PERSON'),
            ];
       // Clipro::firstOrCreateStatic($att, NULL,$att);
        \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%clipro}}',
             ['codpro','rucpro','despro'],[
                                ['000000',$att['rucpro'],$att['despro']],                                
                                ]
                     )->execute();
         
         }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $att=[
            'rucpro'=>h::getIfNotPutSetting('general','DNI_anonimo', 'XXX'),
            'despro'=>h::getIfNotPutSetting('general','nombre_anonimo', 'ANONIMUS PERSON'),
            ];
        \Yii::$app->db->createCommand()->delete('{{%clipro}}', $att)->execute();
        h::settings()->remove('general','DNI_anonimo');
        h::settings()->remove('general','nombre_anonimo');
        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220626_224712_insert_anonimo_clipro cannot be reverted.\n";

        return false;
    }
    */
}
