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
    
    public function hasDocuments(){
        return $this->getDocuments()->count()>0;
    }
    
     public function getVouchers()
    {
       return $this->getDocuments()->where(
                ['sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('BOLETA')]
                );
       
       
    }
    
 
    public function getInvoices()
    {
        return $this->getDocuments()->where(
                ['sunat_tipodoc' => h::sunat()->graw('s.01.tdoc')->g('FACTURA')]
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
   $detiail1 = new SummaryDetail();
$detiail1->setTipoDoc('03')
    ->setSerieNro('B001-3')
    ->setEstado('3')
    ->setClienteTipo('1')
    ->setClienteNro('00000000')
    ->setTotal(129.555)
    ->setMtoOperGravadas(20)
    //->setMtoOperInafectas(24.4)
    //->setMtoOperExoneradas(50)
    //->setMtoOperExportacion(10.555)
   // ->setMtoOtrosCargos(21)
    ->setMtoIGV(3.6);


   $detalles=[$detiail1];
       /* foreach($this->vouchers as $voucher){            
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
             $detalles[]=[$detalle];
          }*/
            
            //var_dump($detalles);die();
            
            $sum = new Summary();
                // Fecha Generacion menor que Fecha Resumen
            $sum->setFecGeneracion(new \DateTime('-3days'))
                ->setFecResumen(new \DateTime('-1days'))
                ->setCorrelativo('001')
                ->setCompany($company)
                ->setDetails($detalles);
            return $sum;
        
    }
    
    
}
