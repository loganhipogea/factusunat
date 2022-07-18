<?php
use console\migrations\baseMigration;
use common\models\masters\Clipro;
use common\models\masters\Centros;
use frontend\modules\com\modelBase\ComSeriesFactura;
use common\models\masters\Almacenes;
use common\helpers\h;
USE frontend\modules\com\models\ComCajaventa;
class m220714_130101_createdatabase extends baseMigration
{
    /**
     * {@inheritdoc}
     */
  public $elements=[
           '{{%centros}}',
           '{{%clipro}}',
           '{{%almacenes}}',
           '{{%direcciones}}',
           '{{%maestroclipro}}',
           '{{%objcli}}',
           ];
    public function safeUp()
    {
        
        /*****************
         * CREANDO UNA EMPRESA TIPO SOCIEDAD
         */
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%clipro}}',
             ['codpro','despro','rucpro','socio','codsoc'],[
            ['1000000001','MI EMPRESA S.A.','20000000000','1','A'],
                                                ]
                     )->execute();
         
       
       
        /*****************
         * CREANDO UN CENTRO COPRRESPONDIENTE A ESTA 
         * EM,PRESA
         */
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%centros}}',
             ['codcen','nomcen','codpro'],[
            ['7050','CENTRO 1','1000000001'],
                       ]
                     )->execute();
         
        
        //$codcen= Centros::find()->andWhere(['codcen'=>'7050'])->one()->codcen;
        /*****************
         * CREANDO UN ALMACEN CORRESPONDIENTE A ESTE
         * CENTRO
         */
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%almacenes}}',
                ['codal','nomal','codcen','tipo',
                 'tipoval','reposicionsololibre',
                 'novalorado','codmon','agregarauto',
                 'bloqueado'
                 ],[
            ['8020','ALMACEN 1','7050','10',
              'P','0',
              '0','PEN','0',
               '0'
                ],
                       ]
                     )->execute();
        
        
        /*****************
         * CREANDO NU PUNTO DE VENTA O CAJA EN ESTA SCUURSAL
         */
          \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%com_cajaventa}}',
                [
                    'codcaja','codsoc','codcen','nombre',
                ],[
            [ 'CJ01','A','7050' ,  'CAJA PRINC', ],
                       ]
                     )->execute();
      
        
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
          /*****************
         * BORRANDO la series 
         */
        ComSeriesFactura::deleteAll();
         /*****************
         * BORRANDO EL  PUNTO DE VENTA O CAJA EN ESTA SCUURSAL
         */
        ComCajaventa::deleteAll( [
                    'codcaja'=>'CJ001',
                    'codsoc'=>'A',
                    'codcen'=>'7050',
                    
                    ]);
        
        /*****************
         * BORRANDO UN ALMACEN CORRESPONDIENTE A ESTE
         * CENTRO
         */
        Almacenes::deleteAll(
                [
                    'codal'=>'8020',
                    
                    ]
                );
       
        /*****************
         * BORARNDO UN CENTRO COPRRESPONDIENTE A ESTA 
         * EM,PRESA
         */
        Centros::deleteAll(
                [
                    'codcen'=>'7050',
                   
                    ]                
                );
       
         /*****************
         * BORRANDO UNA EMPRESA TIPO SOCIEDAD
         */
        Clipro::deleteAll(
                [                   
                    'rucpro'=>'20000000000',                                       
                ]); 
       
    }

   
}
