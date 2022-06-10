<?php
use console\migrations\baseMigration;
class m220610_045646_fill_tabla_documentos extends baseMigration
{
 const NAME_TABLE='{{%documentos}}';
        
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
        return ['codocu','desdocu','clase','tipo','abreviatura'];
    }
    private static function  getData(){
              return [
            ['100', 'GUIA DE REMISION' ,'V','10','GRE'],
            ['101', 'BOLETA DE VENTA' ,'V','10','DGR'],
            ['102', 'FACTURA' ,'D','10','FAC'],
            ['104', 'VALE ALMACEN' ,'D','10','VAL'],
            ['105', 'ORDEN DE COMPRA ' ,'D','10','DVA'],
            ['117', 'ORDEN DE TRABAJO' ,'D','10','OCO'], 
           ['121', 'RECIBO DE HONORARIOS PROF' ,'D','10','OCO'], 
           ['124', 'NOTA DE INGRESO' ,'D','10','DVA'],            
            ];
            
    }
    
    
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
        }
    

    

   
}
