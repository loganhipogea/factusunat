<?php

use console\migrations\baseMigration;

/**
 * Class m230502_213036_create_fill_trasnsacciones
 */
class m230502_213036_create_fill_trasnsacciones extends baseMigration
{
 const NAME_TABLE='{{%transadocs}}';
        
 //const NAME_TABLE_CENTROS='{{%centros}}';
    public function safeUp()
    {
            \Yii::$app->db->createCommand()->
             batchInsert(static::NAME_TABLE,
             $this->fields(), $this->getData())->execute();
    }

    public function safeDown()
    { static::deleteData();
    }

     private static function  fields(){
        return ['id','codtrans','codocu','tipodoc','codestado'];


    }
    private static function  getData(){
              return [
                  ['6','101','100','10','10'],
['32','568','100','10','10'],
['20','103','100','10','10'],
['21','103','102','10','10'],
['36','789','104','10','10'],
['35','345','104','10','10'],
['31','459','104','10','10'],
['22','103','104','10','10'],
['19','500','104','10','10'],
['11','901','104','10','10'],
['12','850','104','10','10'],
['4','100','105','10','10'],
['23','103','105','10','10'],
['10','900','197','10','10'],
['24','103','197','10','10'],
['25','103','198','10','10'],
['26','103','199','10','10'],
['13','102','204','10','10'],
['28','103','204','10','10'],
['33','568','204','10','10'],
['16','145','204','10','10'],
['34','568','459','10','10'],
['17','145','459','10','10'],
['29','103','459','10','10'],
['14','102','459','10','10'],
['30','103','548','10','10'],
['18','145','548','10','10'],
['15','102','548','10','10'],

    ];
            
    }
    
    
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
        }
    


   
}
