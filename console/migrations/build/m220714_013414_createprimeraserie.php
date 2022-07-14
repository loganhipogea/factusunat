<?php

use yii\db\Migration;
USE common\helpers\h;
/**
 * Class m220714_013414_createprimeraserie
 */
class m220714_013414_createprimeraserie extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            /*****************
         * CREA UNA PRIMERA SERIE PARA LA FACTUERA Y LA BOLETA
         */
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%com_series_factura}}',
             ['codcen','serie','tipodoc'],[
            ['7050','F001',h::sunat()->graw('s.01.tdoc')->g('FACTURA')],
            ['7050','B001',h::sunat()->graw('s.01.tdoc')->g('BOLETA')],
                                                ]
                     )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \frontend\modules\com\modelBase\ComSeriesFactura::deleteAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220714_013414_createprimeraserie cannot be reverted.\n";

        return false;
    }
    */
}
