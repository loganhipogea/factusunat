<?php

namespace frontend\modules\com\models;
use common\helpers\h;
use Yii;
/*
 * Libreiras greenter
 */
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\Document;
use Greenter\Model\Company\Address;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\Summary;
/************/
/**
 * This is the model class for table "{{%com_cajadia}}".
 *
 * @property int $id
 * @property int|null $caja_id
 * @property string|null $fecha
 * @property float|null $monto_papel
 * @property float|null $monto_efectivo
 * @property float|null $diferencia
 * @property string|null $estado
 *
 * @property ComCajaventa $caja
 */
class ComCajadia extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public $fecha1=null;
     public $monto_papel1=null;
      public $monto_efectivo1=null;
    public $dateorTimeFields=[
        'fecha'=>self::_FDATE,
        'fecha1'=>self::_FDATE,
    ];
       
        
    CONST ST_PASSED_SUNAT=1;
    CONST ST_MISSING_SUNAT=0;
    CONST ST_REJECT_SUNAT=-1;
    public static function tableName()
    {
        return '{{%com_cajadia}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caja_id'], 'integer'],
            [['codcen'], 'safe'],
           // [['fecha1'], 'integer'],
            [['monto_papel', 'monto_efectivo', 'diferencia'], 'number'],
            //[['fecha'], 'string', 'max' => 10],
            [['estado'], 'string', 'max' => 1],
            [['fecha','caja_id'], 'unique', 'targetAttribute' =>['fecha','caja_id'] ],
            [['caja_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComCajaventa::className(), 'targetAttribute' => ['caja_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'caja_id' => Yii::t('base.names', 'Caja ID'),
            'fecha' => Yii::t('base.names', 'Fecha'),
            'monto_papel' => Yii::t('base.names', 'Monto Papel'),
            'monto_efectivo' => Yii::t('base.names', 'Monto Efectivo'),
            'diferencia' => Yii::t('base.names', 'Diferencia'),
            'estado' => Yii::t('base.names', 'Estado'),
        ];
    }

    /**
     * Gets query for [[Caja]].
     *
     * @return \yii\db\ActiveQuery|ComCajaventaQuery
     */
    public function getCaja()
    {
        return $this->hasOne(ComCajaventa::className(), ['id' => 'caja_id']);
    }
    public function getCentro()
    {
        return $this->hasOne(\common\models\masters\Centros::className(), ['codcen' => 'codcen']);
    }
    
    public function hasDocuments(){
        return $this->getDocuments()->count()>0;
    }
    
     public function getVouchers()
    {
       return $this->getDocuments()->where(
                ['sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('BOLETA')]
                );
       
       
    }
    
  public function getValidVouchers()
    {
       return $this->getValidDocuments()->where(
                [
                    'sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('BOLETA'),
                    //'codestado' => self::ST_CANCELED,
               ]
                );
       
       
    }
    
    public function getInvoices()
    {
        return $this->getDocuments()->where(
                ['sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('FACTURA')]
                );
     }
     
      public function getValidInvoices()
    {
        return $this->getValidDocuments()->where(
                ['sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('FACTURA')]
                );
     }
    
    public function getValidDocuments()
    {
     return $this->hasMany(ComFactura::className(), [
            'caja_id'=>'id'
            //'femision' => 'fecha',
             //'codcen'=>'codcen',
             //'sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('FACTURA'),
            ])->andWhere(
                       [
                        '<>',
                        'codestado',
                        self::ST_CANCELED
                    //'sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('BOLETA'),
                    //'codestado' => self::ST_CANCELED,
                     ] 
                        );
       
       }
   public function getDocuments()
    {
     return $this->hasMany(ComFactura::className(), [
            'caja_id'=>'id'
            //'femision' => 'fecha',
             //'codcen'=>'codcen',
             //'sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('FACTURA'),
            ]);
       
       }

    /**
     * {@inheritdoc}
     * @return ComCajadiaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCajadiaQuery(get_called_class());
    }
    
    
    public function createVouchersGreenter(){
        
      $company= (new Company())
            ->setRuc('20100047218')
            ->setNombreComercial('BOTICAS ARGENTINA')
            ->setRazonSocial('BOTICAS ARGENTINA')
           ;
      
      
      
        $detalles=[];
        $voucher=$this->vouchers[0];
   $detiail1 = new SummaryDetail();
$detiail1->setTipoDoc($voucher->sunat_tipodoc)
    ->setSerieNro($voucher->serie.'-'.(integer)substr($voucher->numero,5))
    ->setEstado('1')
    ->setClienteTipo($voucher->sunat_tipdoccli)
    ->setClienteNro($voucher->rucpro)
    ->setTotal($voucher->total)
    ->setMtoOperGravadas($voucher->setTotalGravado()->sunat_totgrav+0)
    ->setMtoIGV($voucher->sunat_totigv);
$voucher=$this->vouchers[1];
$detiail2 = new SummaryDetail();
$detiail2->setTipoDoc($voucher->sunat_tipodoc)
    ->setSerieNro($voucher->serie.'-'.(integer)substr($voucher->numero,5))
    ->setEstado('1')
    ->setClienteTipo($voucher->sunat_tipdoccli)
    ->setClienteNro($voucher->rucpro)
    ->setTotal($voucher->total)
    ->setMtoOperGravadas($voucher->setTotalGravado()->sunat_totgrav+0)
    ->setMtoIGV($voucher->sunat_totigv);

$voucher=$this->vouchers[2];
$detiail3 = new SummaryDetail();
$detiail3->setTipoDoc($voucher->sunat_tipodoc)
    ->setSerieNro($voucher->serie.'-'.(integer)substr($voucher->numero,5))
    ->setEstado('1')
    ->setClienteTipo($voucher->sunat_tipdoccli)
    ->setClienteNro($voucher->rucpro)
    ->setTotal($voucher->total)
    ->setMtoOperGravadas($voucher->setTotalGravado()->sunat_totgrav+0)
    ->setMtoIGV($voucher->sunat_totigv);

   //$detalles=[$detiail1,$detiail2,$detiail3];
   //var_dump($detalles);die();
        foreach($this->vouchers as $voucher){            
            $detalle = new SummaryDetail();
            $detalle->setTipoDoc('03')
                ->setSerieNro($voucher->serie.'-'.(integer)substr($voucher->numero,5))
                 ->setEstado('1')
                ->setClienteTipo($voucher->sunat_tipdoccli)
               ->setClienteNro($voucher->rucpro)               
               ->setTotal($voucher->total)
              ->setMtoOperGravadas($voucher->setTotalGravado()->sunat_totgrav+0)
              // ->setMtoOperInafectas(24.4)
               // ->setMtoOperExoneradas(50)
               // ->setMtoOperExportacion(10.555)
               // ->setMtoOtrosCargos(21)
                ->setMtoIGV($voucher->sunat_totigv);
             //$detalles[]=[$detalle];
               array_push($detalles,$detalle);
          }
            
            //var_dump($detalles);die();
            
            $sum = new Summary();
                // Fecha Generacion menor que Fecha Resumen
            $sum->setFecGeneracion(new \DateTime($this->swichtDate('fecha', false)))
                ->setFecResumen(new \DateTime(date('Y-m-d')))
                ->setCorrelativo('001')
                ->setCompany($company)
                ->setDetails($detalles);
            return $sum;
        
    }
    
    public function isPassedSunat(){
            return(self::ST_PASSED_SUNAT==$this->estado);
            return $this;
        }
    public function setPassedSunat(){
      $this->estado=self::ST_PASSED_SUNAT;
      return $this;
    }
    public function isRejectedSunat(){
      return(self::ST_REJECT_SUNAT==$this->estado);
    }
    public function setRejectedSunat(){
      $this->estado=self::ST_REJECT_SUNAT;
      return $this;
    }
    
    public function storeSend($errores,$success,$filename=null){
            $modelSend=New \frontend\modules\sunat\models\SunatSendSumary();
            $modelSend->mensaje=$errores;
            $modelSend->caja_id=$this->id;
            //$modelSend->tipodoc=$this->sunat_tipodoc;
            $modelSend->resultado=$success;
             $grabo=$modelSend->save();
             $rutaBase=yii::getAlias('@frontend/modules/sunat/envio/files/');
             //$rutaZip=yii::getAlias('@frontend/modules/sunat/envio/files/'.$modelSend->nameFileCdr());
      //yii::error('@frontend/modules/sunat/envio/files/'.$this->nameFileXml());
               yii::error('verifiacndo el attach');
                yii::error('Nombre de archivos es ');
                yii::error($rutaBase.$filename);
                if(is_file($rutaBase.$filename)){
                     yii::error('Es un archivo  ');
                }else{
                    yii::error('NO es un archivo '); 
                }
               $modelSend->attachFromPath($rutaBase.$filename.'.xml');
              
               $modelSend->attachFromPath('R-'.$rutaBase.$filename.'.zip');
               
               return $grabo;
            //$modelSend->validate();
            //yii::error($modelSend->getErrors(),__FUNCTION__);
        //return $modelSend->save();
    }
    
    
    public function summarySell(){
       return $this->getValidDocuments()->sum('total*cambio');
    }
    public function summaryVouchers(){
       return $this->getValidVouchers()->sum('total*cambio');
    }
    public function summaryInvoices(){
       return $this->getValidInvoices()->sum('total*cambio');
    }
    
    public function hasSends(){
        return \frontend\modules\sunat\models\SunatSendSumary::find()
                ->andWhere(['caja_id'=>$this->id])->exists();
    }
    
    public function setPassToVouchers($status){
      $this->getDb()->createCommand("update {{%com_factura}} set flag_sunat=:flag where (caja_id=:vid and sunat_tipodoc=:tip and codestado <> :codes)",
              [
          'vid'=>$this->id,
          'tip'=>h::sunat()->graw('s.01.tdoc')->g('BOLETA'),
           'flag'=>$status,
           'codes'=>ComFactura::ST_CANCELED
          
      ])->execute();
        
    }
  
}
