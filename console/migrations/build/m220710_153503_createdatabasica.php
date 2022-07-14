<?php
use console\migrations\baseMigration;
use common\models\masters\Clipro;
use common\models\masters\Centros;
use common\models\masters\Almacenes;
USE frontend\modules\com\models\ComCajaventa;
class m220710_153503_createdatabasica extends baseMigration
{
    /**
     * {@inheritdoc}
     */
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
         
        /*Clipro::firstOrCreateStatic(
                [
                    'despro'=>'MI EMPRESA S.A.',
                    'rucpro'=>'10115533',
                    'socio'=>'1',
                    'codsoc'=>'A'                    
                ],
                null,
                ['rucpro'=>'10115533']);*/
       
        /*****************
         * CREANDO UN CENTRO COPRRESPONDIENTE A ESTA 
         * EM,PRESA
         */
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%centros}}',
             ['codcen','nomcen','codpro'],[
            ['7050','CENTRO 1','100001'],
                       ]
                     )->execute();
         
        /*Centros::firstOrCreateStatic(
                [
                    'codcen'=>'7050',
                    'nomcen'=>'CENTRO1',
                    'codpro'=>$codpro,
                    
                    ],null,
                [
                    'codcen'=>'7050',
                   // 'nomcen'=>'CENTRO1',
                    
                    ]
                );*/
        
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
        /*Almacenes::firstOrCreateStatic(
                [
                    'codal'=>'8020',
                    'nomal'=>'ALMACEN1',
                    'codcen'=>'7050',
                    'tipo'=>'10',
                    'tipoval'=>'P',
                    ],null,
                [
                    'codal'=>'8020',
                   // 'nomcen'=>'CENTRO1',
                    
                    ]
                );*/
        
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
       /* ComCajaventa::firstOrCreateStatic( [
                    'codcaja'=>'CJ001',
                    'codsoc'=>'A',
                    'codcen'=>'7050',
                    'nombre'=>'CAJA PRINCIPAL',
                    //'tipoval'=>'P',
                    ],null,
                [
                    'codcaja'=>'CJ001',
                   // 'nomcen'=>'CENTRO1',
                    
                    ]);*/
        
        

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
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
