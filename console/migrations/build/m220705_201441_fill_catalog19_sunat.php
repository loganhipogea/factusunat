<?php
use console\migrations\baseMigration;
class m220705_201441_fill_catalog19_sunat extends baseMigration
{
   public $table='{{%combovalores}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%combovalores}}',
             ['nombretabla','codigo','valor','valor1'],[
['s.19.estitem','1','ADICIONAR','EMITIR'],
['s.19.estitem','2','MODIFICAR','MODIFICAR'],
['s.19.estitem','3','ANULAR','ANULAR'],
['s.19.estitem','4','ANULADO DIA','ANULARD'],
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
       \Yii::$app->db->createCommand(
           "delete from {{%combovalores}} where nombretabla like 's.19.estitem'")->execute();
      }

   
}
