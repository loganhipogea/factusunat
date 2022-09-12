<?php
namespace frontend\modules\com\models;
/*
 * Libreiras greenter
 */
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Client\Client;

use Greenter\Model\Company\Address;
/************/

use Yii;
use common\helpers\h;
use common\behaviors\FileBehavior;
use common\models\masters\Clipro;
use common\models\masters\Centros;
use frontend\modules\sunat\Module as ModuloSunat;
use common\models\masters\VwSociedades;
USE Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
USE Greenter\Model\Company\Company;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\Summary;
use frontend\modules\com\modelBase\ComSeriesFactura;
class ComFactura extends \common\models\base\BaseDocument
{
    
    const SCE_CREACION_RAPIDA='scerapida';//Punto de venta ventas rapidas
    CONST ST_PASSED_SUNAT='30';
    //CONST ST_MISSING_SUNAT=0;
    CONST ST_REJECT_SUNAT='40';
    CONST ST_VOIDED_SUNAT='48';
    const CHARACTER_SEPARATOR_FOR_DATA_QR='|';
    public $femision1=null;
    public $fvencimiento1=null;
    public $dateorTimeFields=[
          'femision'=>self::_FDATE,
        'femision1'=>self::_FDATE,
          'fvencimiento'=>self::_FDATE,
        'fvencimiento1'=>self::_FDATE,
        
    ];
    private $_serie=null;
    public static function estados(){
        
        return 
                parent::estados() +
                [
                self::ST_PASSED_SUNAT=>\yii::t('base.names','SUNAT-ACEP'),
                self::ST_REJECT_SUNAT=>\yii::t('base.names','SUNAT-RECH'),
                self::ST_VOIDED_SUNAT=>\yii::t('base.names','SUNAT-BAJA'),
                //self::ST_CANCELED=>\yii::t('base.names','ANULADO'),
                ]
                ;
    }
        

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
                'descuento','subtotal','sunat_totisc','totalventa',
                 'sunta_tipdoccli','cambio','tipopago'
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
                'sunat_tipodoc','rucpro','sunat_tipdoccli','tipopago'], 'required', 'message' => yii::t('base.errors','This field is T required')],
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
            //YII::ERROR('Es factura',__FUNCTION__);
            if(empty($this->rucpro)){
                 //YII::ERROR('RUC VACION',__FUNCTION__);
                $this->addError('rucpro',yii::t('base.errors','This field is required'));
                return ;               
            }else{//Si escribió RUC validarlo
                // YII::ERROR('VALIDANDO EL RUC',__FUNCTION__);
                $validatorRuc=new \yii\validators\RegularExpressionValidator([
                    'pattern'=>h::gsetting('general', 'formatoRUC'),
                            ]); 
               
                if(!$validatorRuc->validate($this->rucpro)){ 
                   //YII::ERROR('Agregando el error al campo rucpro ',__FUNCTION__); 
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
            //yii::error('es boleta');
            //yii::error($this->isClientWithDni());
            if($this->isClientWithDni()){ //VALIDAR EL DNI  
                // yii::error('patenr');
                 //yii::error(h::gsetting('general', 'formatoDNI'));
                     $validatorDni=new \yii\validators\RegularExpressionValidator(
                     [
                        'pattern'=>h::gsetting('general', 'formatoDNI'),
                    ]);
                  if(!$validatorDni->validate($this->rucpro)){ 
                          //yii::error('Encontro un error en la validaicon dni ');
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
             'sunat_totigv' => Yii::t('base.names', 'Igv'),
            'femision1' => Yii::t('base.names', 'F. emi f'),
           
            ];
    }
    
    
   public function getClipro()
    {
        return $this->hasOne(\common\models\masters\Clipro::className(), ['rucpro' => 'rucpro']);
    }
    
    public function getCaja()
    {
        return $this->hasOne(ComCajadia::className(), ['id' => 'caja_id']);
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
            //yii::error($this->attributes);
           //echo $this->currentDateInFormat(); die();
          $this->codestado=self::ST_CREATED;
          /*
           * Tipo cambio
           */
          $this->cambio=($this->codmon=='USD')?h::tipoCambio('USD')['compra']:1;
         
            $this->setSerie();
          
          $this->numero= $this->serie.'-'.$this->correlative($this->serie);
          $this->femision=$this->currentDateInFormat();
          $this->hemision=date('h:i:s');
         // $this->flag_sunat=self::ST_MISSING_SUNAT; //Neutro pendiente de
          
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
     public function getSends()
    {
        return $this->hasMany(\frontend\modules\sunat\models\SunatSends::className(), ['doc_id' => 'id']);
    }
   public function preparePdfInvoice(){      
       $socio=$this->socio;
       $numero=$this->numero;
       $formato=h::formato();
       h::money()->setCurrentMoneyInCache($this->codmon);
       $file=dirname(dirname(__DIR__)).'/com/views/com/templates/Invoice_template.php';
       $targetPath=yii::getAlias('@temp').'/'. $numero.'.pdf';
       $fileQr=yii::getAlias('@temp').'/'. $numero.'QR.png';       
       $pdf=New \FPDF('P','mm',array(80,150)); 
        $qrCode = (new \Da\QrCode\QrCode($this->generateNameForQr()))
            ->setSize(100)
            ->setMargin(1);   
                $qrCode->writeFile($fileQr);      
        $pdf->AddPage();
                define('EURO',$this->codmon);
       // CABECERA
            $pdf->SetFont('Helvetica','B',8);
            /*
             *      ANCHO 70 ; ALTO 10; TEXTO, , BORDE 0, POSICION 1,'CENTRADO 'C'
             */
            $pdf->Cell(70,4,$socio->despro,0,1,'C');
            $pdf->SetFont('Helvetica','',6);
            $pdf->Cell(60,3,$socio->rucpro,0,1,'C');
           // $pdf->Cell(60,4,'C/ Arturo Soria, 1',0,1,'C');
            $pdf->Cell(60,3,$socio->firstAddress(),0,1,'C');
            $pdf->Cell(60,3,$socio->telpro,0,1,'C');
            $pdf->Cell(60,3,$socio->web,0,1,'C');
            
        /*
         * TITULO DEL VOUCHER 
         */
            $nombreDoc=($this->isInvoice())?ModuloSunat::NAME_FACTURA_ELECTRONICA:ModuloSunat::NAME_BOLETA_ELECTRONICA;
            $pdf->Cell(60,0,'','T',0,'CT');
            $pdf->Ln(2);
            $pdf->Cell(60,0,$nombreDoc,0,1,'C');
            $pdf->Ln(2);
            $pdf->Cell(60,0,$this->numero,0,1,'C');
            $pdf->Ln(2);
            $pdf->Cell(60,0,'','T',0,'CT');
           
        // DATOS FACTURA        
            $pdf->Ln(1);
            //$pdf->Cell(60,4,'Factura Simpl.:'.$this->numero,0,1,'L');
            $pdf->Cell(30,6,'Fecha: '.$this->femision.':'.$this->hemision,0,0,'');
            $pdf->Cell(30,6,'Metodo de pago:'.$this->comboValueText('tipopago'),0,0,'');
            $pdf->Ln(2);
            $pdf->Cell(30,6,'Sucursal: '.$this->codcen,0,0,'');
            $pdf->Cell(30,6,'Caja:'.$this->caja->caja->nombre,0,0,'');
            $pdf->Ln(2);
            $pdf->Cell(60,6,'Cliente: '.$this->nombre_cliente,0,0,'');
            $pdf->Ln(2);
            $pdf->Cell(60,6,'DNI/RUC:'.$this->rucpro,0,0,'');
            $pdf->Ln(2);
            // COLUMNAS
            $pdf->SetFont('Helvetica', '', 7);
            //$pdf->Cell(30, 10, 'Producto', 0);
            $pdf->Cell(5, 10, 'Item',0,0,'R');
            $pdf->Cell(10, 10, 'Codart',0,0,'R');
            $pdf->Cell(5, 10, 'Um',0,0,'R');
            $pdf->Cell(10, 10, 'Cant',0,0,'R');
            $pdf->Cell(10, 10, 'Punit',0,0,'R');
            $pdf->Cell(10, 10, 'D Unit',0,0,'R');
            $pdf->Cell(10, 10, 'Total',0,0,'R');
            $pdf->Ln(8);
            $pdf->Cell(60,0,'','T');
            $pdf->Ln(0);
 
        // PRODUCTOS
           
            foreach($this->details as $detail){ 
           
                //$pdf->MultiCell(30,5,$detail->descripcion,0,'L'); 
                $pdf->Cell(5,5, $detail->item,0,0,'R');
                $pdf->Cell(10, 5,$detail->codart,0,0,'R');
                $pdf->Cell(5, 5, $detail->codum,0,0,'R');
                $pdf->Cell(10, 5, $detail->cant,0,0,'R');
                $pdf->Cell(10, 5, $detail->punit+$detail->descuento,0,0,'R');
                $pdf->Cell(10, 5, $detail->descuento,0,0,'R');
                $pdf->Cell(10, 5, $detail->punit*$detail->cant,0,0,'R');
                $pdf->Ln(3);   
                 $pdf->SetFont('Courier', 'B', 6);
                    $pdf->Cell(60, 4, $detail->descripcion,0,0,'L'); 
                  $pdf->SetFont('Helvetica', '', 7);
                $pdf->Ln(3); 
            }
     $pdf->SetFont('Helvetica','',7);

        $pdf->Ln(1);
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(2);
        $pdf->Cell(20, 4, '', 0,0);
        $pdf->Cell(25, 4, 'Op gravadas',0, 0,'L');
        $pdf->Cell(15, 4, $formato->asDecimal($this->sunat_totgrav,2),0,0,'R');
       
        $pdf->Ln(4);
       
        
         $pdf->Cell(20, 4, '', 0);
        $pdf->Cell(25, 4, 'Total Dcto.', 0,0,'L');
        $pdf->Cell(15,4, $formato->asDecimal(empty($this->descuento)?'':$this->descuento,2),0,0,'R');
        $pdf->Ln(4);
        
        
        $pdf->Cell(20, 4, '', 0);
        $pdf->Cell(25, 4, 'IGV '.(h::gsetting('general', 'igv')*100).' %',0,0,'L');
        $pdf->Cell(15, 4, $formato->asDecimal($this->sunat_totigv,2),0,0,'R');
        $pdf->Ln(4);
        $pdf->SetFont('Helvetica','B',7);
        $pdf->Cell(20, 4, '', 0);
        $pdf->Cell(25, 4, 'Total',0,0,'L');
        $pdf->Cell(15, 4,h::money()->money['simbolo'].$formato->asDecimal($this->total,2),0,0,'R');
        $pdf->SetFont('Helvetica','',7);
        $pdf->Ln(4);
  
          $pdf->Cell(30,7,'Pagó: '.$this->codcen,0,0,'');
            $pdf->Cell(30,7,'Vuelto:'.$this->caja->caja->nombre,0,0,'');
            $pdf->Ln(4);
       // $pdf->Ln(10);
       
        $pdf->Ln(2);
        $pdf->Image($fileQr);
        //$pdf->Output('D');
        $pdf->Output($targetPath,'f');
        $this->attachFromPath($targetPath);
        @unlink($targetPath);
        //return $targetPath;
         
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
     // $this->total=$this->getDetails()->sum('punitgravado*cant');
      //echo $this->getDetails()->sum('punitgravado*cant')->create
      $this->total=$this->sunat_totimpuestos+$this->subtotal;
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
  

  
  public function isPassedSunat(){
      return(self::ST_PASSED_SUNAT==$this->codestado);
  }
  public function setPassedSunat(){
      $this->codestado=self::ST_PASSED_SUNAT;
      return $this;
  }
  public function isRejectedSunat(){
      return(self::ST_REJECT_SUNAT==$this->codestado);
  }
  public function setRejectedSunat(){
      $this->codestado=self::ST_REJECT_SUNAT;
      return $this;
  }
  public function setCreated(){
      $this->codestado=self::ST_CREATED;
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
                ->setDireccion($direccionSocio->direc))
              ;
     $clipro=$this->clipro;
     $direccionCliente=$clipro->firstAddress(true);
       
     $client = new Client();
     //var_dump($this->sunat_tipdoccli);die();
        $client->setTipoDoc($this->sunat_tipdoccli) //Catalogo Sunat 06 TIPODOCIDENTIDAD  6= REGISTRO UNICO CONTRIBUYENTYE
            ->setNumDoc($this->rucpro)
            ->setRznSocial($clipro->despro)
            ->setAddress((new Address())
                ->setDireccion($direccionCliente->direc))
               ;
      
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
  public function storeSend($object,$success,$filename,$ticket=null,$type){
     // var_dump($filename);die();
      $modelSend=New \frontend\modules\sunat\models\SunatSends();
      $modelSend->mensaje=$object;
       $modelSend->doc_id=$this->id;
        $modelSend->ticket=$ticket;
        $modelSend->tipo=$type;
        $modelSend->tipodoc=$this->sunat_tipodoc;
        $modelSend->resultado=$success;
      $grabo=$modelSend->save();
       $rutaBase=yii::getAlias('@frontend/modules/sunat/envio/files/');            
               $modelSend->attachFromPath($rutaBase.$filename.'.xml');              
               $modelSend->attachFromPath($rutaBase.'R-'.$filename.'.zip');
               //unlink($rutaBase.$filename.'.xml');
                //unlink($rutaBase.'R-'.$filename.'.zip');
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
            $company= $this->companyGreenter();
          
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
  
 private function generateNameForQr(){
     $arrayPieces=[
         $this->socio->rucpro,
         $this->sunat_tipodoc,
         $this->serie,
         substr($this->numero,5),
         $this->sunat_totigv,
          $this->total,
         $this->swichtDate('femision', false),
         $this->sunat_tipdoccli,
         $this->rucpro,
     ];
     return join(self::CHARACTER_SEPARATOR_FOR_DATA_QR,
            $arrayPieces);
 }
  private function companyGreenter(){
      $socio=$this->socio;      
      $company=new Company();
            $company->setRuc($socio->rucpro)
            ->setNombreComercial(substr($socio->despro,0,20))
            ->setRazonSocial($socio->despro);
            //var_dump(VwSociedades::rucpro());die();
        
    return $company;  
  }
  
 public function createVoidedInvoiceGreenter(){
     $company=$this->companyGreenter(); 
            $detalle = new VoidedDetail();
            $detalle->setTipoDoc($this->sunat_tipodoc)
                ->setSerie($this->serie)
               ->setCorrelativo(substr($this->numero,5))
               ->setDesMotivoBaja('ERROR EN CÁLCULOS');
      $detalles=[$detalle]; 
            $sum = new Voided();
                // Fecha Generacion menor que Fecha Resumen
            $sum->setFecGeneracion(new \DateTime($this->swichtDate('femision', false)))
                 ->setFecComunicacion(new \DateTime())
                ->setCorrelativo('001')
                ->setCompany($company)
                ->setDetails($detalles);
           
         return $sum;
 }
 
 public function createVoidedVoucherGreenter(){
     
        $detalle = new SummaryDetail();
        $detalle->setTipoDoc($this->sunat_tipodoc)
    ->setSerieNro($this->serie.'-'.(integer)substr($this->numero,5))
    ->setEstado(h::sunat()->graw('s.19.estitem')->g('ANULAR'))
    ->setClienteTipo($this->sunat_tipdoccli)
    ->setClienteNro($this->rucpro)
    ->setTotal($this->total)
    ->setMtoOperGravadas(20)
    //->setMtoOperInafectas(24.4)
    //->setMtoOperExoneradas(50)
    //->setMtoOperExportacion(10.555)
    //->setMtoOtrosCargos(21)
    ->setMtoIGV($this->sunat_totigv);         
            $sum = new Summary();
                // Fecha Generacion menor que Fecha Resumen
            $sum->setFecGeneracion(new \DateTime($this->swichtDate('femision', false)))
                ->setFecResumen(new \DateTime(date('Y-m-d')))
                ->setCorrelativo('001')
                ->setCompany($this->companyGreenter())
                ->setDetails([$detalle]);
            return $sum;
   }
   
  public function canCancel(){
      return in_array($this->codestado,
              [
                  self::ST_CREATED,
                  self::ST_PASSED,
                 // self::ST_PASSED_SUNAT,
              ]);
  }
   public function canAprobe(){
      return in_array($this->codestado,
              [
                  self::ST_CREATED,                  
              ]);
      
  }
   public function canSendSunat(){
      return in_array($this->codestado,
              [                 
                  self::ST_PASSED,
                  self::ST_REJECT_SUNAT,
              ]);
  }
  public function canVoidSunat(){
      return in_array($this->codestado,
              [                 
                  self::ST_PASSED_SUNAT,
                  self::ST_REJECT_SUNAT,
              ]);
  }
 public function canRebuildReport(){
       return in_array($this->codestado,
              [                 
                  self::ST_PASSED,
                  self::ST_CREATED,
              ]);
  }
  public function canTransport(){
      return in_array($this->codestado,
              [                 
                  self::ST_PASSED,
                  self::ST_PASSED_SUNAT,
                  self::ST_REJECT_SUNAT,
                  //self::ST_VOIDED_SUNAT,
              ]); 
  }
  
  public function lastSend(){
     RETURN  $this->getSends()->orderBy(['cuando'=>SORT_DESC])->one();
  }
  /*
   * El adjunto
   */
  public function pathPdf(){
      if($this->hasAttachments())
      return $this->files[0];
      return '';
  }
  /*
   * El adjunto del ultimo cdr
   */
  public function urlCdr(){
    if(!is_null($modSend=$this->lastSend())){
        yii::error('no es nulo el ulñtimo send EL ID ES  '.$modSend->id,__FUNCTION__);
      return $modSend->urlCdr();
    }else{
        yii::error('No encontro el ulñtim send ',__FUNCTION__);
        return '';
    }
      
  }
  /*
   * El adjunto del ultimo Xml
   */
  public function urlXml(){
    if(!is_null($modSend=$this->lastSend())){
        return $modSend->urlXml(); 
    }else{
        return '';
    }
  }
  
  public function hasSends(){
      return $this->getSends()->count()>0;
  }
  
  public function serie(){
      
    if(is_null($this->_serie)){        
          $this->_serie= ComSeriesFactura::serie($this->sunat_tipodoc,$this->codcen); 
       }
       
      return $this->_serie;
    }
  public function setSerie(){
      $this->serie=$this->serie();
  }
}
