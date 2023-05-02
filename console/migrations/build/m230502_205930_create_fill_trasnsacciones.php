<?php

use console\migrations\baseMigration;

/**
 * Class m230502_205930_create_fill_trasnsacciones
 */
class m230502_205930_create_fill_trasnsacciones extends baseMigration
{
 const NAME_TABLE='{{%transacciones}}';
        
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
        return ['codtrans','descripcion','signo','detalles',
            'exigirvalidacion','afecta_reserva','afecta_precio',
            'inversa_id','exigehistorial'];

    }
    private static function  getData(){
              return [
['100','INGRESO POR COMPRA ','1','Todos los movimientos que aumente en el stock a traves de una orden de compra ','0','0','1','901',''],
['101','INGRESO POR CONSIGNACION','1','','','','','',''],
['102','SALIDA PARA ORDEN','-1','Salida de mercadería por venta','0','1','0','500',''],
['103','REINGRESO','1','','0','0','0','','1'],
['145','INGRESO PARA ORDEN','1','','0','1','1','458',''],
['345','INGRESO POR TRANSFERENCIA','1','','1','0','1','','0'],
['445','[X]-SALIDA PARA TRANSFER','1','','1','0','0','568','1'],
['458','[X]-INGRESO PARA ORDEN','-1','','0','1','0','145',''],
['459','[X]-REINGRESO','1','','1','0','0','103',''],
['500','[X]-SALIDA PARA ORDEN','1','','0','1','0','102',''],
['568','SALIDA PARA TRANSFERENCIA','-1','','0','0','0','345','1'],
['789','[X]-INGRESO PARA TRANSFERENCIA','1','','0','0','0','345','1'],
['850','[X]-SALIDA CECO','-1','','1','0','0','',''],
['900','SALIDA PARA CECO','-1','Cuando calificas a un colector','','','','',''],
['901','[X]-INGRESO POR COMPRA','-1','','1','0','0','',''],
           
            ];
            
    }
    
    
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
        } 
   

   
}
