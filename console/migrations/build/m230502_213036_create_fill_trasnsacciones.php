<?php

use console\migrations\baseMigration;

/**
 * Class m230502_213036_create_fill_trasnsacciones
 */
class m230502_213036_create_fill_trasnsacciones extends baseMigration
{
 const NAME_TABLE='{{%transadocs}}';
  const NAME_TABLE_DOCS='{{%documentos}}';
        
 //const NAME_TABLE_CENTROS='{{%centros}}';
    public function safeUp()
    {
       \Yii::$app->db->createCommand()->
         batchInsert(static::NAME_TABLE_DOCS,
         ['codocu','desdocu','modelo'],
                [['197','REGISTRO CECO','\frontend\modules\cc\models\CcCc'],
                ['198','ORDEN DE VENTA','\frontend\modules\com\models\ComCotizacion'],
                ['199','COTIZACION','\common\models\masters\Bancos'],
                ['204','ORDEN DE TRABAJO','\common\models\masters\Bancos'],
                ['459','ORDEN DE INVERSION','\common\models\masters\Bancos'],
                ['548','ORDEN DE VENTA','\common\models\masters\Cargos'],
                ]                
                 )->execute();
        
        
        
            \Yii::$app->db->createCommand()->
             batchInsert(static::NAME_TABLE,
             $this->fields(), $this->getData())->execute();
            
            
       
    }

    public function safeDown()
    { static::deleteData();
    }

     private static function  fields(){
        return ['codtrans','codocu','tipodoc','codestado'];


    }
    private static function  getData(){
              return [
                  ['101','100','10','10'],
['568','100','10','10'],
['103','100','10','10'],
['103','102','10','10'],
['789','104','10','10'],
['345','104','10','10'],
['459','104','10','10'],
['103','104','10','10'],
['500','104','10','10'],
['901','104','10','10'],
['850','104','10','10'],
['100','105','10','10'],
['103','105','10','10'],
['900','197','10','10'],
['103','197','10','10'],
['103','198','10','10'],
['103','199','10','10'],
['102','204','10','10'],
['103','204','10','10'],
['568','204','10','10'],
['145','204','10','10'],
['568','459','10','10'],
['145','459','10','10'],
['103','459','10','10'],
['102','459','10','10'],
['103','548','10','10'],
['145','548','10','10'],
['102','548','10','10'],

    ];
            
    }
    
    
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
        (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)->Where(['codocu','in',['197','198','199','204','459','548']])
    ->execute();  
          
        }
    


   
}
