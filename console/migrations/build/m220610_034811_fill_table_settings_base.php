<?php
use console\migrations\baseMigration;

class m220610_034811_fill_table_settings_base extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const NAME_TABLE='{{%setting}}';
        
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

    
    private static function  getData(){
              return [
                    ['string','mail','servermail','smtp.googlemail.com',1,'\N',1565117407,1565117407],
['string','mail','userservermail','tutoria.psicologia.ara@uni.edu.pe',1,'',1565117407,1589406219],
['string','mail','passworduserservermail','486d47he',1,'',1565117407,1589406230],
['string','mail','portservermail','465',1,'',1565117407,1585324502],
['string','general','formatoRUC','/[1-9]{1}[0-9]{10}/',1,'\N',1565117447,1565117447],
['string','general','formatoDNI','/[0-9]{8}/',1,'\N',1565117447,1565117447],
['double','general','igv','0.18',1,'\N',1565117447,1565117447],
['string','general','moneda','PEN',1,'\N',1565117447,1565117447],
['string','timeUser','date','dd/mm/yyyy',1,'\N',1565117447,1565117447],
['string','timeUser','datetime','dd/mm/yyyy hh:ii:ss',1,'\N',1565117447,1565117447],
['string','timeUser','time','hh:ii:ss',1,'\N',1565117447,1565117447],
['string','timeBD','date','Y-m-d',1,'\N',1565117447,1565117447],
['string','timeBD','datetime','Y-m-d H:i:s',1,'\N',1565117447,1565117447],
['string','timeBD','time','H:i:s',1,'\N',1565117447,1565117447],
['string','timeBD','hour','H:i',1,'\N',1478787878,14546679],
['string','timeUser','hour','hh:ii',1,'\N',1454579,1446464],
['string','mail1','servermail','smtp.googlemail.com',1,'\N',1656117407,1656117407],
['string','mail1','userservermail','neotegnia@gmail.com',1,'\N',1656117407,1656117407],
['string','mail1','passworduserservermail','tomasgrecia_1',1,'\N',1656117407,1656117407],
['string','mail1','portservermail','465',1,'\N',1656117407,1656117407],
['integer','mail','NumMaxCantCorreos','99',1,'Número máximo de cantidad de destinatarios antes de partir deatinataarios ',1589911771,1589917042],

           ];      
            
    }
    
    private static function  fields(){
        return ['type','section','key','value','status','description','created_at','updated_at'];
    }
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
        }
    

    

   
}
