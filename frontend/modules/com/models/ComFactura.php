<?php
namespace frontend\modules\com\models;
/*
 * Libreiras greenter
 */
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
/************/

use Yii;
use common\helpers\h;
use common\behaviors\FileBehavior;
use common\models\masters\Clipro;
use common\models\masters\Centros;
class ComFactura extends \common\models\base\BaseDocument
{
    
    const SCE_CREACION_RAPIDA='scerapida';//Punto de venta ventas rapidas
    CONST ST_PASSED_SUNAT=1;
    CONST ST_MISSING_SUNAT=0;
    CONST ST_REJECT_SUNAT=-1;
    public $femision1=null;
    public $fvencimiento1=null;
    public $dateorTimeFields=[
          'femision'=>self::_FDATE,
        'femision1'=>self::_FDATE,
          'fvencimiento'=>self::_FDATE,
        'fvencimiento1'=>self::_FDATE,
        
    ];
    /*public $booleanFields=[
          'flag_sunat',
    ];*/
    public $total1=null;
    public static function tableName()
    {
        return '{{%com_factura}}';
    }    
    public function rules()
    {
        return [
            
             [[
                'sunat_totexo','sunat_totigv','sunat_totimpuestos','caja_id',
                'descuento','subtotal','sunat_totisc','totalventa','sunta_tipdoccli'
               ],
                 'safe'
             ],            
             /*
             * Validacion del RUC O DNI en punto de venta
             */
             [['serie','codestado','rucpro','total','flag_sunat'], 'safe'],
             ['rucpro', 'validaterucdni',/* 'on' => self::SCE_CREACION_RAPIDA*/],
             //['nombre_cliente', 'validateChilds',/* 'on' => self::SCE_CREACION_RAPIDA*/],
             //[['rucpro'], 'required'],
            [['codcen','nombre_cliente','codsoc',
                'sunat_tipodoc','rucpro','sunat_tipdoccli'], 'required', 'message' => yii::t('base.errors','This field is T required')],
            [['codsoc'], 'string', 'max' => 1],
            [['numero'], 'string', 'max' => 13],
            [['femision', 'fvencimiento'], 'string', 'max' => 10],
            [['sunat_tipodoc', 'tipopago'], 'string', 'max' => 2],
            [['codmon'], 'string', 'max' => 4],
            [['codcen'], 'string', 'max' => 5],
              [['serie','codestado','rucpro'], 'safe'],
            [['codcen','nombre_cliente'], 'safe',],
            [['rucpro'], 'string', 'max' => 14],
            [['hemision'], 'safe',],
            [['rucpro'], 'exist', 'skipOnError' => false, 'targetClass' => Clipro::className(), 'targetAttribute' => ['rucpro' => 'rucpro']],
            [['sunat_hemision'], 'string', 'max' => 11],
        ];
    }
    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_CREACION_RAPIDA] = [
                'codsoc', 'codcen', 'rucpro',
                'femision', 'sunat_tipodoc', 'tipopago', 'codmon', 
                'codestado', 'sunat_hemision','nombre_cliente','hemision',
            ];
        return $scenarios;
    }
    
    public function isInvoice(){
        //var_dump($this->sunat_tipodoc,self::TYPE_DOC_INVOICE);
        return ($this->sunat_tipodoc==h::sunat()->graw('s.01.tdoc')->g('FACTURA'))?true:false;
    }
    public function isBoleta(){
        //var_dump($this->sunat_tipodoc,self::TYPE_DOC_INVOICE);
        return ($this->sunat_tipodoc==h::sunat()->graw('s.01.tdoc')->g('BOLETA'))?true:false;
    }
    
    public function isClientWithDni(){
        return $this->sunat_tipdoccli==h::sunat()->graw('s.06.tdociden')->g('DNI');
    }
     
     public function isClientForeigCarnetExtranejeria(){
        return $this->sunat_tipdoccli==h::sunat()->graw('s.06.tdociden')->g('CEXT');
    }
    public function isClientForeigPassport(){
        return $this->sunat_tipdoccli==h::sunat()->graw('s.06.tdociden')->g('PASAP');
    }
     public function isClientAnonimus(){
        return $this->sunat_tipdoccli==h::sunat()->graw('s.06.tdociden')->g('ANONIMO');
    }
    /*public function validateChilds(){
        if(!$this->hasInvoiceItems())
         $this->addError ('nombre_cliente',yii::t('base.errors','This document has no childs'));
    }*/
    public function validaterucdni($attribute,$params){
        //echo "salio"; die();
        //\yii::error('validando',__FUNCTION__);
        if($this->isInvoice()){
            YII::ERROR('Es factura',__FUNCTION__);
            if(empty($this->rucpro)){
                 YII::ERROR('RUC VACION',__FUNCTION__);
                $this->addError('rucpro',yii::t('base.errors','This field is required'));
                return ;               
            }else{//Si escribió RUC validarlo
                 YII::ERROR('VALIDANDO EL RUC',__FUNCTION__);
                $validatorRuc=new \yii\validators\RegularExpressionValidator([
                    'pattern'=>h::gsetting('general', 'formatoRUC'),
                            ]); 
               
                if(!$validatorRuc->validate($this->rucpro)){ 
                   YII::ERROR('Agregando el error al campo rucpro ',__FUNCTION__); 
                           $this->addError('rucpro',yii::t('base.errors','Invalid format'));
                             
                     }
           }
        }else{//En el caso que haya escogido boleta
                /*
                 * Pueden haber varios casos para una boleta
                 * DNI
                 * CARNET DE EXTRAJERIA
                 * PASAPORTE Y ANONIMO
                 * Segun los valores del campo 
                 * sunat_tipdoccli
                 */
            yii::error('es boleta');
            yii::error($this->isClientWithDni());
            if($this->isClientWithDni()){ //VALIDAR EL DNI  
                 yii::error('patenr');
                 yii::error(h::gsetting('general', 'formatoDNI'));
                     $validatorDni=new \yii\validators\RegularExpressionValidator(
                     [
                        'pattern'=>h::gsetting('general', 'formatoDNI'),
                    ]);
                  if(!$validatorDni->validate($this->rucpro)){ 
                          yii::error('Encontro un error en la validaicon dni ');
                         $this->addError('rucpro',yii::t('base.errors','Invalid format'));
                            return ;  
                     }
                
            }elseif($this->isClientForeigCarnetExtranejeria()){
                
            }elseif($this->isClientForeigPassport()){
                
            }elseif($this->isClientForeigCarnetExtranejeria()){
                
            }elseif($this->isClientAnonimus()){
                if(!($this->rucpro==h::gsetting('general', 'DNI_anonimo'))){
                    $this->addError('rucpro',yii::t('base.errors','Invalid format'));
                            return ;
                }
            }
            
        }
    }
    
    public function beforeValidate() {
        $this->codcen=Centros::find()->one()->codcen;
        if($this->isInvoice())$this->sunat_tipdoccli=h::sunat ()-> 
              graw('s.01.tdoc')->g('FACTURA');
        return parent::beforeValidate();
    }
    
     
    public function behaviors() {
        return [
            
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
           
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'codsoc' => Yii::t('base.names', 'Soc'),
            'numero' => Yii::t('base.names', 'Num'),
            'femision' => Yii::t('base.names', 'F. emi'),
            'fvencimiento' => Yii::t('base.names', 'F venc'),
            'sunat_tipodoc' => Yii::t('base.names', 'T doc'),
            'codmon' => Yii::t('base.names', 'Moneda'),
            'tipopago' => Yii::t('base.names', 'T. Pago'),
            'rucpro' => Yii::t('base.names', 'RUC/DNI/Doc'),
            'sunat_hemision' => Yii::t('base.names', 'H emi'),
            'serie' => Yii::t('base.names', 'Serie'),
            'codestado' => Yii::t('base.names', 'Estado'),
            'nombre_cliente' => Yii::t('base.names', 'Cliente'),
            'sunat_tipodoccli' => Yii::t('base.names', 'Doc id'),
            'femision1' => Yii::t('base.names', 'F. emi f'),
           
            ];
    }
    
    
   public function getClipro()
    {
        return $this->hasOne(\common\models\masters\Clipro::className(), ['rucpro' => 'rucpro']);
    }
    
    public function getSocio()
    {
        
        return $this->hasOne(\common\models\masters\Clipro::className(), ['codsoc' => 'codsoc']);
    }
   
    public static function find()
    {
        return new ComFacturaQuery(get_called_class());
    }
    
    private function correlative($prefix){
       $siguiente=  $this->find()->andWhere(['serie'=>$prefix])->count() +1;
       return str_pad($siguiente.'',8,'0',STR_PAD_LEFT);
       
    }
    
    public function beforeSave($insert) {
        IF($insert){
           //echo $this->currentDateInFormat(); die();
          $this->codestado=self::ST_CREATED;
          if($this->isInvoice()){
            $this->serie='F001'; 
            $this->sunat_tipdoccli=h::sunat()->graw('s.06.tdociden')->g('RUC');
          }else{
            $this->serie='B001';
            //$this->sunat_tipdoccli=h::sunat()->graw('s.06.tdociden')->g('DNI');
          }
            
          $this->numero= $this->serie.'-'.$this->correlative($this->serie);
          $this->femision=$this->currentDateInFormat();
          $this->hemision=date('h:i:s');
          $this->flag_sunat=self::ST_MISSING_SUNAT; //Neutro pendiente de
          
        }        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert){
            //$this->refresh();
           // $this->preparePdf($this->id);
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function setStatus($status){
        $this->codestado=$status;
        return $this->save();
    }
    public function getDetails()
    {
        return $this->hasMany(ComFactudet::className(), ['factu_id' => 'id']);
    }
   public function preparePdfInvoice(){      
       $socio=$this->socio;
       $numero=$this->numero;
       $file=dirname(dirname(__DIR__)).'/com/views/com/templates/Invoice_template.php';
       $targetPath=yii::getAlias('@temp').'/'. $numero.'.pdf';
       $fileQr=yii::getAlias('@temp').'/'. $numero.'QR.png';       
       $pdf=New \FPDF('P','mm',array(80,150)); 
        $qrCode = (new \Da\QrCode\QrCode('This is my text'))
            ->setSize(50)
            ->setMargin(5);   
                $qrCode->writeFile($fileQr);      
        $pdf->AddPage();
                define('EURO',$this->codmon);
       // CABECERA
            $pdf->SetFont('Helvetica','',9);
            $pdf->Cell(60,4,$socio->despro,0,1,'C');
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4,$socio->rucpro,0,1,'C');
           // $pdf->Cell(60,4,'C/ Arturo Soria, 1',0,1,'C');
            $pdf->Cell(60,4,$socio->firstAddress(),0,1,'C');
            $pdf->Cell(60,4,$socio->telpro,0,1,'C');
            $pdf->Cell(60,4,$socio->web,0,1,'C');
 
        // DATOS FACTURA        
            $pdf->Ln(5);
            $pdf->Cell(60,4,'Factura Simpl.:'.$this->numero,0,1,'');
            $pdf->Cell(60,4,'Fecha: '.$this->femision.':'.$this->hemision,0,1,'');
            $pdf->Cell(60,4,'Metodo de pago:'.$this->tipopago,0,1,'');
 
            // COLUMNAS
            $pdf->SetFont('Helvetica', 'B', 7);
            $pdf->Cell(30, 10, 'Producto', 0);
            $pdf->Cell(5, 10, 'Ud',0,0,'R');
            $pdf->Cell(10, 10, 'Precio',0,0,'R');
            $pdf->Cell(15, 10, 'Total',0,0,'R');
            $pdf->Ln(8);
            $pdf->Cell(60,0,'','T');
            $pdf->Ln(0);
 
        // PRODUCTOS
           
            foreach($this->details as $detail){ 
           
                $pdf->MultiCell(30,4,$detail->descripcion,0,'L'); 
                $pdf->Cell(35, -5, $detail->cant,0,0,'R');
                $pdf->Cell(10, -5,$detail->punit.EURO,0,0,'R');
                $pdf->Cell(15, -5, $detail->pventa.EURO,0,0,'R');
                $pdf->Ln(3);               
                            
            }
     $pdf->SetFont('Helvetica','',8);
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
        $pdf->Ln(6);
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(2);    
        $pdf->Cell(25, 10, 'TOTAL SIN IGV', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, number_format(round((round(12.25,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
        $pdf->Ln(3);    
        $pdf->Cell(25, 10, 'IGV 18%', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, number_format(round((round(12.25,2)),2)-round((round(2*3,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
        $pdf->Ln(3);    
        $pdf->Cell(25, 10, 'TOTAL', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, number_format(round(12.25,2), 2, ',', ' ').EURO,0,0,'R');
 
// PIE DE PAGINA
        $pdf->Ln(10);
        $pdf->Cell(60,0,'EL PERIODO DE DEVOLUCIONES',0,1,'C');
        $pdf->Ln(3);
        $pdf->Cell(60,0,'CADUCA EL DIA  01/11/2019',0,1,'C');
        $pdf->Ln(2);
        $pdf->Image($fileQr);
        $pdf->Output($targetPath,'f');
        $this->attachFromPath($targetPath); 
         
   }
   
   /*
    * BOLETA DE VENTA
    */
   public function preparePdfVoucher(){      
       $socio=$this->socio;
       $numero=$this->numero;
       $file=dirname(dirname(__DIR__)).'/com/views/com/templates/Invoice_template.php';
       $targetPath=yii::getAlias('@temp').'/'. $numero.'.pdf';
       $fileQr=yii::getAlias('@temp').'/'. $numero.'QR.png';       
       $pdf=New \FPDF('P','mm',array(80,150)); 
        $qrCode = (new \Da\QrCode\QrCode('This is my text'))
            ->setSize(50)
            ->setMargin(5);   
                $qrCode->writeFile($fileQr);      
        $pdf->AddPage();
                define('EURO',$this->codmon);
       // CABECERA
            $pdf->SetFont('Helvetica','',12);
            $pdf->Cell(60,4,$socio->despro,0,1,'C');
            $pdf->SetFont('Helvetica','',8);
            $pdf->Cell(60,4,$socio->rucpro,0,1,'C');
           // $pdf->Cell(60,4,'C/ Arturo Soria, 1',0,1,'C');
            $pdf->Cell(60,4,$socio->firstAddress(),0,1,'C');
            $pdf->Cell(60,4,$socio->telpro,0,1,'C');
            $pdf->Cell(60,4,$socio->web,0,1,'C');
 
        // DATOS FACTURA        
            $pdf->Ln(5);
            $pdf->Cell(60,4,'Factura Simpl.:'.$this->numero,0,1,'');
            $pdf->Cell(60,4,'Fecha: '.$this->femision.':'.$this->hemision,0,1,'');
            $pdf->Cell(60,4,'Metodo de pago:'.$this->tipopago,0,1,'');
 
            // COLUMNAS
            $pdf->SetFont('Courier', '', 7);
            $pdf->Cell(30, 10, 'Producto', 0);
            $pdf->Cell(5, 10, 'Ud',0,0,'R');
            $pdf->Cell(10, 10, 'Precio',0,0,'R');
            $pdf->Cell(15, 10, 'Total',0,0,'R');
            $pdf->Ln(8);
            $pdf->Cell(60,0,'','T');
            $pdf->Ln(0);
 
        // PRODUCTOS
           
            foreach($this->details as $detail){ 
           
                $pdf->MultiCell(30,4,$detail->descripcion,0,'L'); 
                $pdf->Cell(35, -5, $detail->cant,0,0,'R');
                $pdf->Cell(15, -5,$detail->punit,0,0,'R');
                $pdf->Cell(10, -5, $detail->pventa,0,0,'R');
                $pdf->Ln(3);               
                            
            }
     $pdf->SetFont('Helvetica','',8);
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
        $pdf->Ln(6);
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(2);    
        $pdf->Cell(25, 10, 'TOTAL SIN IGV', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, number_format(round((round(12.25,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
        $pdf->Ln(3);    
        $pdf->Cell(25, 10, 'IGV 18%', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, number_format(round((round(12.25,2)),2)-round((round(2*3,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
        $pdf->Ln(3);    
        $pdf->Cell(25, 10, 'TOTAL', 0);    
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, number_format(round(12.25,2), 2, ',', ' ').EURO,0,0,'R');
 
// PIE DE PAGINA
        $pdf->Ln(10);
        $pdf->Cell(60,0,'EL PERIODO DE DEVOLUCIONES',0,1,'C');
        $pdf->Ln(3);
        $pdf->Cell(60,0,'CADUCA EL DIA  01/11/2019',0,1,'C');
        $pdf->Ln(2);
        $pdf->Image($fileQr);
        $pdf->Output($targetPath,'f');
        $this->attachFromPath($targetPath); 
         
   }
  
  
  
  public function setIgv(){
      $this->sunat_totigv=$this->gIgv();
      return $this;
  }
  private function gIgv(){
       return $this->getDetails()->sum('igv');
  }
    
  public function setIsc(){
      $this->sunat_totisc=$this->gIsc();
      return $this;
  }
  
  private function gIsc(){
       return $this->getDetails()->sum('isc');
  }
 
  /*
   * Revisar
   */
  public function setSubtotal(){
      $this->subtotal=$this->gSubtotal();
      return $this;
  }
  
  private function gSubtotal(){
       return $this->getDetails()->sum('pventa');
  }
  /**/
  
  
  
  /*
   * Total precio de venta, osea sin impuestos
   */
  public function setTotalVenta(){
      $this->totalventa=$this->gTotalVenta();
      return $this;
  }
  private function gTotalVenta(){
       return $this->getDetails()->sum('pventa');
  }
  /*
   * 
   */
  
  
  
  public function setTotalImpuestos(){
      $this->sunat_totimpuestos=$this->gTotalImpuestos();
      return $this;
  }
  private function gTotalImpuestos(){
       return $this->sunat_totisc+$this->sunat_totigv;
  }
  
  
  public function setTotalGravado(){
      $this->sunat_totgrav=$this->gTotalGravado();
      return $this;
  }
  
  
  private function gTotalGravado(){
       return    $this->getDetails()->andWhere([
           'sunat_codtipoafectacion'=>h::sunat()->gRaw('s.07.tafectacion')->g('GONERO')
               ])->sum('pventa') ;
  }
  
  
  public function setTotalTotales(){
      $this->total=$this->getDetails()->sum('punitgravado*cant') ;
      return $this;
  }
  
  
  /*
   * REFRESCA LOS CAMPOS NO NORMALIZAOS
    QUE DEPENDEN DEL DETALLE 
   */
  public function refreshValues(){
     return  $this->setIgv()->setIsc()->setTotalImpuestos()
             ->setSubtotal()->setTotalGravado()->setTotalVenta()->
             setTotalTotales()->save();
  }
  
  public function isCreated(){
      return(self::ST_CREATED==$this->codestado);
  }
  
  public function isRemoved(){
      return(self::ST_CANCELED==$this->codestado);
  }
   public function setRemoved(){
      $this->codestado=self::ST_CANCELED;
      return $this;
  }
  
  public function isPassed(){
      return(self::ST_PASSED==$this->codestado);
  }
  public function setPassed(){
      $this->codestado=self::STA_PASSED;
      return $this;
  }
  
  public function isPassedSunat(){
      return(self::ST_PASSED_SUNAT==$this->flag_sunat);
  }
  public function setPassedSunat(){
      $this->flag_sunat=self::ST_PASSED_SUNAT;
      return $this;
  }
  public function isRejectedSunat(){
      return(self::ST_REJECT_SUNAT==$this->flag_sunat);
  }
  public function setRejectedSunat(){
      $this->flag_sunat=self::ST_REJECT_SUNAT;
      return $this;
  }
  
  
  public function hasInvoiceItems(){
     return  $this->getDetails()->count()>0;
  }
  public function passInvoice(){
      return $this->setPassed()->save();
  }
  public function removeInvoice(){
      return $this->setRemoved()->save();
  }
  
  
  
  /*
   * Funcion para coger las clases de
   * la libreria Greenter
   */
  public function createInvoiceGreenter(){
      $socio=$this->socio;
      $direccionSocio=$socio->firstAddress(true);
      $company= (new Company())
            ->setRuc($socio->rucpro)
            ->setNombreComercial(substr($socio->despro,20))
            ->setRazonSocial($socio->despro)
            ->setAddress((new Address())
                /*->setUbigueo('150101')
                ->setDistrito('LIMA')
                ->setProvincia('LIMA')
                ->setDepartamento('LIMA')
                ->setUrbanizacion('CASUARINAS')
                ->setCodLocal('0000')*/
                ->setDireccion($direccionSocio->direc))
            //->setEmail('admin@greenter.com')
            //->setTelephone('01-234455')
              ;
     $clipro=$this->clipro;
     $direccionCliente=$clipro->firstAddress(true);
       
     $client = new Client();
        $client->setTipoDoc('6') //Catalogo Sunat 06 TIPODOCIDENTIDAD  6= REGISTRO UNICO CONTRIBUYENTYE
            ->setNumDoc($this->rucpro)
            ->setRznSocial($clipro->despro)
            ->setAddress((new Address())
                ->setDireccion($direccionCliente->direc))
            //->setEmail('client@corp.com')
           // ->setTelephone('01-445566')
                ;
        
      /*$invoice
    ->setUblVersion('2.1')
    ->setFecVencimiento(new \DateTime())
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('125')
    ->setFechaEmision(new \DateTime())
    ->setFormaPago(new FormaPagoContado())
    ->setTipoMoneda('PEN')
    ->setCompany($util->shared->getCompany())
    ->setClient($util->shared->getClient())
    ->setMtoOperGravadas(200)
    ->setMtoOperExoneradas(100)
    ->setMtoIGV(36)
    ->setTotalImpuestos(36)
    ->setValorVenta(300)
    ->setSubTotal(336)
    ->setMtoImpVenta(336)
    ;*/
        //VAR_DUMP((((integer)(SUBSTR($this->numero,5))+0).''));DIE();
      $invoice=New Invoice();
      $invoice
    ->setUblVersion('2.1')
    ->setFecVencimiento(new \DateTime())
    ->setTipoOperacion('0101')
    ->setTipoDoc($this->sunat_tipodoc)
    ->setSerie($this->serie)
    ->setCorrelativo((((integer)(SUBSTR($this->numero,5))+0).''))
    ->setFechaEmision(new \DateTime())
    ->setFormaPago(new FormaPagoContado())
    ->setTipoMoneda($this->codmon)
    ->setCompany($company)
    ->setClient($client)
    ->setMtoOperGravadas($this->setTotalGravado()->sunat_totgrav+0)
    //->setMtoOperExoneradas($vALOR)
    ->setMtoIGV($this->sunat_totigv)
    ->setTotalImpuestos($this->setTotalImpuestos()->sunat_totimpuestos)
    ->setValorVenta($this->setTotalVenta()->totalventa)
    ->setSubTotal($this->total)
    ->setMtoImpVenta($this->total);
      
      return $invoice;
  }
  
  /*
   * Almacena los datos del envio
   */
  public function storeSend($object,$success){
      $modelSend=New \frontend\modules\sunat\models\SunatSends();
      $modelSend->mensaje=$object;
       $modelSend->doc_id=$this->id;
        $modelSend->tipodoc=$this->sunat_tipodoc;
        $modelSend->resultado=$success;
      $grabo=$modelSend->save();
      yii::error('@frontend/modules/sunat/envio/files/'.$this->nameFileXml());
      $modelSend->attachFromPath(yii::getAlias('@frontend/modules/sunat/envio/files/'.$this->nameFileXml()));
     $modelSend->attachFromPath(yii::getAlias('@frontend/modules/sunat/envio/files/'.$this->nameFileCdr()));
     return $grabo;
//yii::error($modelSend->getErrors());
  }
  
 public function iconStatusSunat(){
     
    if( $this->isRejectedSunat()){
        $color='#ec0a0a';
        $gly='glyphicon glyphicon-remove-sign';
    }elseif($this->isPassedSunat()){
        $color='#52be0a';
        $gly='glyphicon glyphicon-send';
    }else{
        $color='#fcc218';
        $gly='glyphicon glyphicon-info-sign';
    }
    return '<i style="font-size:1.5em;color:'.$color.'"><span class="'.$gly.'"></span>';
 }
 
 
 /*
   * Funcion para coger las clases de
   * la libreria Greenter
   */
  public function createVoucherGreenter(){
           
            
            $socio=$this->socio;
            $company= (new Company())
            ->setRuc($socio->rucpro)
            ->setNombreComercial(substr($socio->despro,20))
            ->setRazonSocial($socio->despro);
    /*
     * Client segun el tipo de documento ingresado
     */        
          
               $client = new Client();
                $client->setTipoDoc($this->sunat_tipdoccli)
                 ->setNumDoc($this->rucpro)
                    ->setRznSocial($this->nombre_cliente);
          
            
            // Venta
        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101')
            ->setTipoDoc($this->sunat_tipodoc)
            ->setSerie($this->serie)
           ->setCorrelativo((((integer)(SUBSTR($this->numero,5))+0).''))
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda($this->codmon)
            ->setCompany($company)
            ->setClient($client)
            ->setMtoOperGravadas($this->setTotalGravado()->sunat_totgrav+0)
            ->setMtoIGV($this->sunat_totigv)
            ->setTotalImpuestos($this->setTotalImpuestos()->sunat_totimpuestos)
            ->setValorVenta($this->setTotalVenta()->totalventa)
            ->setSubTotal($this->total)
            ->setMtoImpVenta($this->total);
       return $invoice;
  }
  
 private function nameFileXml(){
     return $this->socio->rucpro.'-'.
             $this->sunat_tipodoc.'-'.
             $this->serie.'-'.(integer)(substr($this->numero,5)).'.xml';
 }
 
 private function nameFileCdr(){
     return 'R-'.$this->socio->rucpro.'-'.
             $this->sunat_tipodoc.'-'.
             $this->serie.'-'.(integer)(substr($this->numero,5)).'.zip';
 }
 
}
