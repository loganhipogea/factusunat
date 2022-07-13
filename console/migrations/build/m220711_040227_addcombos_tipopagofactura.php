<?php
use console\migrations\baseMigration;
class m220711_040227_addcombos_tipopagofactura extends baseMigration
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
['com_factura.tipopago','10','EFECTIVO','EF'],
['com_factura.tipopago','20','YAPE','YA'],
['com_factura.tipopago','30','TARJETA','VI'],
['com_factura.tipopago','40','OTRO','OT'],
]
                     )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {        
       \Yii::$app->db->createCommand(
           "delete from {{%combovalores}} where nombretabla like '%com_factura.tipopago%'")->execute();
      }

   
}
