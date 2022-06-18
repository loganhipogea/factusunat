<?php

use yii\db\Migration;

/**
 * Class m220617_033130_fill_datos_bancos
 */
class m220617_033130_fill_datos_bancos extends Migration
{
    const NAME_TABLE='{{%bancos}}';
    public function safeUp()
    {
            \Yii::$app->db->createCommand()->
             batchInsert(static::NAME_TABLE,
             ['codbanco','nombre'], 
             [
              ['BCP','BANCO DE CREDITO'],
              ['BBVA','BANCO CONTINENTAL']
             ])->execute();
    }

    public function safeDown()
    { 
         (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();       
    }
}