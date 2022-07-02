<?php
use console\migrations\baseMigration;
class m220627_205302_fill_masters_sunat extends baseMigration
{
   public $table='{{%combovalores}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         if($this->existsColumn($this->table,'valor1')){  
            $this->alterColumn($this->table, 'valor1', $this->string(12));
        }
         \Yii::$app->db->createCommand()->
             batchInsert(
                     '{{%combovalores}}',
             ['nombretabla','codigo','valor','valor1'],[
['s.01.tdoc','00','OTROS','OTRO'],
['s.01.tdoc','01','FACTURA','FACTURA'],
['s.01.tdoc','02','R H','RH'],
['s.01.tdoc','03','BOLETA VENTA','BOLETA'],
['s.01.tdoc','04','LIQ COMPRA','LIQCOMPRA'],
['s.01.tdoc','05','BOLET VUELO COMER','BOLAVION'],
['s.01.tdoc','06','CARTA PORTE AEREO','CARTAPA'],
['s.01.tdoc','07','NOTA CREDITO','NC'],
['s.01.tdoc','08','NOTA DEBITO','ND'],
['s.01.tdoc','09','GUIA REMISION','GR'],
['s.01.tdoc','10','RECIBO ARRENDAM','RARR'],
['s.01.tdoc','11','POLIZA DE BVALORES','POLBV'],
['s.01.tdoc','12','TICKET MAQ REGISTRAD','TCK'],

 ['s.05.ttributo','1000','IGV','IGV'],
['s.05.ttributo','1016','Imp Venta Arroz Pilado','IVAP'],
['s.05.ttributo','2000','ISC','ISC'],
['s.05.ttributo','7152','Impuesto  bolsa plastica','ICBPER'],
['s.05.ttributo','9995','Expor','EXP'],
['s.05.ttributo','9996','Gratuito','GRA'],
['s.05.ttributo','9997','Exonerado','EXO'],
['s.05.ttributo','9998','Inafecto','INA'],
['s.05.ttributo','9999','Otros tributos','OTROS'],


 ['s.06.tdociden','0','DOC.TRIB.NO.DOM.SIN.RUC','ANONIMO'],
['s.06.tdociden','1','Documento Nacional de Identidad','DNI'],
['s.06.tdociden','4','Carnet de extranjería','CEXT'],
['s.06.tdociden','6','Registro Unico de Contributentes','RUC'],
['s.06.tdociden','7','Pasaporte','PASAP'],
['s.06.tdociden','A','Cédula Diplomática de identidad','CED'],
['s.06.tdociden','B','DOC.IDENT.PAIS.RESIDENCIA-NO.D','DIPR'],
['s.06.tdociden','C','Tax Identification Number - TIN – Doc Trib PP.NN','TAX'],
['s.06.tdociden','D','Identification Number - IN – Doc Trib PP. JJ','IDN'],
['s.06.tdociden','E','TAM- Tarjeta Andina de Migración ','TAM'],
['s.07.tafectacion','10','Gravado - Oper Onerosa','GONERO'],
['s.07.tafectacion','11','Gravado – Retiro por premio','GRPREMI'],
['s.07.tafectacion','12','Gravado – Retiro por donación','GRDONA'],
['s.07.tafectacion','13','Gravado – Retiro ','GRRET'],
['s.07.tafectacion','14','Gravado – Retiro por publicidad','GRPUBL'],
['s.07.tafectacion','15','Gravado – Bonificaciones','GRBONI'],
['s.07.tafectacion','16','Gravado – Retiro por entrega a trabajadores','GRETRAB'],
['s.07.tafectacion','17','Gravado - IVAP','GRIVAP'],
['s.07.tafectacion','20','Exonerado - Oper Onerosa','EXOPONE'],
['s.07.tafectacion','21','Exonerado - Transferencia gratuita','EXTRAGRA'],
['s.07.tafectacion','30','Inafecto - Oper Onerosa','INAONER'],
['s.07.tafectacion','31','Inafecto – Retiro por Bonificación','INREBONI'],
['s.07.tafectacion','32','Inafecto – Retiro','INARET'],
['s.07.tafectacion','33','Inafecto – Retiro por Muestras Médicas','INAMMEDI'],
['s.07.tafectacion','34','Inafecto - Retiro por Convenio Colectivo','INARETPREMI'],
['s.07.tafectacion','35','Inafecto – Retiro por premio','INARETPREMI'],
['s.07.tafectacion','36','Inafecto - Retiro por publicidad','INARETPUBLI'],
['s.07.tafectacion','37','Inafecto - Transferencia gratuita','INATRAGRA'],
['s.07.tafectacion','40','Expor de Bienes o Serv.','EXPBIESERV'],
['s.51.topera','0101','Venta interna','VINTERNA'],
['s.51.topera','0112','Venta Interna - Sust Gastos Deducibles Pers Natural','VINTGDEDU'],
['s.51.topera','0113','Venta Interna-NRUS','VINRUS'],
['s.51.topera','0200','Expor de Bienes','EXPORBIE'],
['s.51.topera','0201','Expor Serv–Prestac serv realizados en el país','EXSERPERU'],
['s.51.topera','0202','Expor Serv–Prestac de serv de hospedaje No Domici','EXSEREXTR'],
['s.51.topera','0203','Expor Serv–Transp de navieras','EXSERTNAV'],
['s.51.topera','0204','Expor Serv–Serv.  a naves y aeronaves extr','EXSERNEXTR'],
['s.51.topera','0205','Expor Serv.  - Serv.Paquete Turís','EXSERPQT'],
['s.51.topera','0206','Expor Serv–Serv. complem al transporte de carga','EXSERTRC'],
['s.51.topera','0207','Expor Serv–Suministro de e eléct a domiciliados en ZED','EXSERSEE'],
['s.51.topera','0208','Expor Serv–Prestac serv realizados parcialm extranjero','EXSERTEXT'],
['s.51.topera','0301','Operaciones con Carta de porte aéreo','OPCPAER'],
['s.51.topera','0302','Operaciones de Transp ferroviario de pasajeros','OPTRAFERR'],
['s.51.topera','0303','Operaciones de Pago de regalía petrolera','OPREGPETR'],
['s.51.topera','0401','Ventas no domicili no califican como exportación','VNODOM'],
['s.51.topera','1001','Oper Sujeta a Detracción','OPDETRA'],
['s.51.topera','1002','Oper Sujeta a Detracción- Recursos Hidrobiológicos','OPDETRAPA'],
['s.51.topera','1003','Oper Sujeta a Detracción- Serv. de Transp Pasajeros','OPDETRAP'],
['s.51.topera','1004','Oper Sujeta a Detracción- Serv. de Transp Carga','OPDETRATRAC'],
['s.51.topera','2001','Oper Sujeta a Percepción','OPPERCEP'],

]
                     )->execute();
         
         
         
           /*$this->putCombo('{{%ums}}','codum', [
               'NIU'=>'UN',
                'KGM'=>'KG',
               'MTR'=>'M',
                'GRM'=>'GR',
               'CMT'=>'CM',
           ]);*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
       \Yii::$app->db->createCommand(
           "delete from {{%combovalores}} where nombretabla like 's.05%'")->execute();
       \Yii::$app->db->createCommand(
           "delete from {{%combovalores}} where nombretabla like 's.06%'")->execute();
    \Yii::$app->db->createCommand(
           "delete from {{%combovalores}} where nombretabla like 's.07%'")->execute();
       \Yii::$app->db->createCommand(
           "delete from {{%combovalores}} where nombretabla like 's.01%'")->execute();
    if($this->existsColumn($this->table,'valor1')){  
            $this->alterColumn($this->table, 'valor1', $this->string(3));
        }
       
    }

   
}
