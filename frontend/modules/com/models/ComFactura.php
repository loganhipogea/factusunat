<?php
namespace frontend\modules\com\models;
use Yii;
use common\helpers\h;
use common\behaviors\FileBehavior;
use common\models\masters\Clipro;
use common\models\masters\Centros;
class ComFactura extends \common\models\base\modelBase
{
    
    const SCE_CREACION_RAPIDA='scerapida';//Punto de venta ventas rapidas
    public $dateorTimeFields=[
          'femision'=>self::_FDATE,
          'fvencimiento'=>self::_FDATE,
    ];
    public static function tableName()
    {
        return '{{%com_factura}}';
    }    
    public function rules()
    {
        return [
             /*
             * Validacion del RUC O DNI en punto de venta
             */
             [['serie','codestado','rucpro'], 'safe'],
             ['rucpro', 'validaterucdni',/* 'on' => self::SCE_CREACION_RAPIDA*/],
             //[['rucpro'], 'required'],
            [['codcen','codsoc','sunat_tipodoc','rucpro'], 'required', 'message' => yii::t('base.errors','This field is T required')],
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
        return ($this->sunat_tipodoc==self::TYPE_DOC_INVOICE)?true:false;
    }
    
    
    public function validaterucdni($attribute,$params){
        //echo "salio"; die();
        \yii::error('validando',__FUNCTION__);
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
                   YII::ERROR('VALIDO BIEN EL RUC ',__FUNCTION__); 
                           $this->addError('rucpro',yii::t('base.errors','Invalid format'));
                            return ;  
                     }
           }
        }else{//En el caso que haya escogido boleta
            YII::ERROR('Es boleta',__FUNCTION__);
           if(empty($this->rucpro)){ //Si no llenó nada aquí tiene que llenar el nombre por lo menos
               if(empty($this->nombre_cliente)){
                 $this->addError('rucpro',yii::t('base.errors','This field is required'));
                 return;  
               }
            }else{//Si escribió DNI validarlo
               if(!$this->rucpro===h::gsetting('general','DNI_anonimo')){
                  $validatorDni=new \yii\validators\RegularExpressionValidator(
                     [
                        'pattern'=>h::gsetting('general', 'formatoDNI'),
                    ]);
                  if(!$validatorDni->validate($this->rucpro)){ 
                           $this->addError('rucpro',yii::t('base.errors','Invalid format'));
                            return ;  
                     } 
               }
                
           } 
        }
    }
    
    public function beforeValidate() {
        $this->codcen=Centros::find()->one()->codcen;
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
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'numero' => Yii::t('base.names', 'Numero'),
            'femision' => Yii::t('base.names', 'Femision'),
            'fvencimiento' => Yii::t('base.names', 'Fvencimiento'),
            'sunat_tipodoc' => Yii::t('base.names', 'Sunat Tipodoc'),
            'codmon' => Yii::t('base.names', 'Codmon'),
            'tipopago' => Yii::t('base.names', 'Tipopago'),
            'rucpro' => Yii::t('base.names', 'Rucpro'),
            'sunat_hemision' => Yii::t('base.names', 'Sunat Hemision'),
        ];
    }
    
    
   public function getClipro()
    {
        return $this->hasOne(\common\models\masters\Clipro::className(), ['rucpro' => 'rucpro']);
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
          $this->serie='F01';  
          $this->numero= $this->serie.'-'.$this->correlative($this->serie);
          $this->femision=$this->currentDateInFormat();
          $this->hemision=date('h:i:s');
          
        }        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert){
            $this->preparePdf($this->numero);
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function setStatus($status){
        $this->codestado=$status;
        return $this->save();
    }
    
   private function preparePdf($numero){
       $file=dirname(dirname(__DIR__)).'/com/views/com/templates/Invoice_template.php';
       $targetPath=yii::getAlias('@temp').'/'. $numero.'.pdf';
       $fileQr=yii::getAlias('@temp').'/'. $numero.'QR.png';
       
       $pdf=New \FPDF('P','mm',array(80,150)); 
       
      

    $qrCode = (new \Da\QrCode\QrCode('This is my text'))
    ->setSize(50)
    ->setMargin(5);
   // ->useForegroundColor(51, 153, 255);
    
    $qrCode->writeFile($fileQr);
      //$cad= $qrCode->writeString();
       
       
       $pdf->AddPage();
       define('EURO',chr(128));
       // CABECERA
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(60,4,'Lacodigoteca.com',0,1,'C');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(60,4,'C.I.F.: 01234567A',0,1,'C');
$pdf->Cell(60,4,'C/ Arturo Soria, 1',0,1,'C');
$pdf->Cell(60,4,'C.P.: 28028 Madrid (Madrid)',0,1,'C');
$pdf->Cell(60,4,'999 888 777',0,1,'C');
$pdf->Cell(60,4,'alfredo@lacodigoteca.com',0,1,'C');
 
// DATOS FACTURA        
$pdf->Ln(5);
$pdf->Cell(60,4,'Factura Simpl.: F2019-000001',0,1,'');
$pdf->Cell(60,4,'Fecha: 28/10/2019',0,1,'');
$pdf->Cell(60,4,'Metodo de pago: Tarjeta',0,1,'');
 
// COLUMNAS
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->Cell(30, 10, 'Articulo', 0);
$pdf->Cell(5, 10, 'Ud',0,0,'R');
$pdf->Cell(10, 10, 'Precio',0,0,'R');
$pdf->Cell(15, 10, 'Total',0,0,'R');
$pdf->Ln(8);
$pdf->Cell(60,0,'','T');
$pdf->Ln(0);
 
// PRODUCTOS
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell(30,4,'Manzana golden 1Kg que peude ser la panace a d ee abiail',0,'L'); 
$pdf->Cell(35, -5, '2',0,0,'R');
$pdf->Cell(10, -5, number_format(round(3,2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Cell(15, -5, number_format(round(2*3,2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Ln(3);
$pdf->MultiCell(30,4,'Malla naranjas 3Kg',0,'L'); 
$pdf->Cell(35, -5, '1',0,0,'R');
$pdf->Cell(10, -5, number_format(round(1.25,2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Cell(15, -5, number_format(round(1.25,2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Ln(3);
$pdf->MultiCell(30,4,'Uvas',0,'L'); 
$pdf->Cell(35, -5, '5',0,0,'R');
$pdf->Cell(10, -5, number_format(round(1,2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Cell(15, -5, number_format(round(1*5,2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Ln(3);
 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$pdf->Ln(6);
$pdf->Cell(60,0,'','T');
$pdf->Ln(2);    
$pdf->Cell(25, 10, 'TOTAL SIN I.V.A.', 0);    
$pdf->Cell(20, 10, '', 0);
$pdf->Cell(15, 10, number_format(round((round(12.25,2)/1.21),2), 2, ',', ' ').EURO,0,0,'R');
$pdf->Ln(3);    
$pdf->Cell(25, 10, 'I.V.A. 21%', 0);    
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
  
       
       
       /*$pdf=new \Mpdf\Mpdf();
       // $stylesheet = file_get_contents(\yii::getAlias("@frontend/web/css/bootstrap.min.css")); // external css
        //$stylesheet2 = file_get_contents(\yii::getAlias("@frontend/web/css/reporte.css")); // external css
        //$pdf->WriteHTML($stylesheet, 1);
       $pdf->WriteHTML( \Yii::$app->view->
           renderFile($file,[]
                         ));
         $pdf-> Output($targetPath, \Mpdf\Output\Destination::FILE);
      /*Yii::$app->html2pdf
    ->convertFile($file, ['pageSize' => 'A4'])
    ->saveAs($targetPath);*/
      /*$pdf=new \mikehaertl\wkhtmlto\Pdf($file);
      $pdf->saveAs($targetPath);*/
         
   }
}
