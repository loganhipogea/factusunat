<?php

namespace frontend\modules\com\models;
use common\models\masters\Centros;
use common\models\masters\Almacenes;
use common\models\masters\Maestrocompo;
use frontend\modules\logi\models\LogiVwStock;
use common\helpers\h;
use Yii;

class ComFactudet extends \common\models\base\modelBase
{
    public $subtotal=0;
    public $subtotal_raw=0;
    public $descripcion_fake='';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_factudet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cant',],'required'],
            [['isc', 'descuento','gravado','exo','igv','punitgravado','pventa','totimpuesto'],'safe'],
            [['factu_id'], 'integer'],
             [['punit','cant','pventa'], 'number'],
            [['sunat_tipodoc'], 'safe'],
            [['punit', 'pventa', 'cant', 'igv', 'descuento'], 'number'],
            [['item'], 'string', 'max' => 3],
            [['codsoc'], 'string', 'max' => 1],
            [['codcen', 'codum', 'sunat_codtributo'], 'string', 'max' => 4],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 200],
            [['sunat_codtipoprecio', 'sunat_codtipoafectacion'], 'string', 'max' => 2],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }
    
    /*
     * EXISTEN 2 SITUACIONES PARA ESTE ITEM 
     * 1) El tipo de tributo (CATALOG 05 SUNAT)
     *    Los más frecuentes: 
     *     1000 IGV          h::sunat()->gRaw('s.05.ttributo')->g('IGV')
     *     2000 ISC          h::sunat()->gRaw('s.05.ttributo')->g('ISC')
     *          
     * 
     * 
     * 2) El tipo de afectación del tributo CATALOG 07 SUNAT
     *    10: GRAVADO        h::sunat()->gRaw('s.07.tafectacion')->g('GONERO')
     *    20: EXONERADO      h::sunat()->gRaw('s.07.tafectacion')->g('EXOPONE')
     * 
     * 
     *   CASO MAS SIMPLE:  IGV + GRAVADO
     *   CASO 2         :  IGV + EXONERADO
     *   CASO 3         :  IGV + ISC +GRAVADO
     * 
     *  OBS: PARA FINES PRACTICOS SE DEBE DE COLOCAR EL TIPO DE 
     *       TRIBUTO IGV EN TODOS LOS CASOS 
     * 
     *       sunat_codtipoatributo=h::sunat()->gRaw('s.05.ttributo')->g('IGV');
     *       
     *       El resto de condiciones lo hallaremos con las condiciones 
     *         hasISC()
     *         isExonerado()
     *         isInvoice()
     * 
     * 
     */
    
    
    
    
   

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'factu_id' => Yii::t('base.names', 'Factu ID'),
            'item' => Yii::t('base.names', 'Item'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'codum' => Yii::t('base.names', 'Codum'),
            'codart' => Yii::t('base.names', 'Codart'),
            'punit' => Yii::t('base.names', 'P. venta'),
            'punitgravado' => Yii::t('base.names', 'P.unit'),
            'pventa' => Yii::t('base.names', 'Subto'),
            'cant' => Yii::t('base.names', 'Cant'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'igv' => Yii::t('base.names', 'Igv'),
            'descuento' => Yii::t('base.names', 'Descuento'),
            'sunat_codtipoprecio' => Yii::t('base.names', 'Sunat Codtipoprecio'),
            'sunat_codtributo' => Yii::t('base.names', 'Sunat Codtributo'),
            'sunat_codtipoafectacion' => Yii::t('base.names', 'Sunat Codtipoafectacion'),
        ];
    }

    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }
    
    public function getFactura()
    {
        return $this->hasOne(ComFactura::className(), ['id' => 'factu_id']);
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentroQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * {@inheritdoc}
     * @return ComFactudetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComFactudetQuery(get_called_class());
    }
    
    public function beforeValidate() {
        $this->setAttributes([
    'item' => '100',
    'codsoc' => 'A',
    'codcen' => Centros::find()->one()->codcen,
    //'codal' => Almacenes::find()->one()->codal,
               ]);
     $this->codum='NIU';
    // $this->punit=$this->stock->valor;
        RETURN parent::beforeValidate();
    }
    
    public function isInvoice(){
        return ($this->sunat_tipodoc==self::TYPE_DOC_INVOICE)?true:false;
    } 
    public function beforeSave($insert) {
        $this->refreshValues();
        return parent::beforeSave($insert);
    }
     public function afterSave($insert, $changedAttributes) {
         if(count($changedAttributes)>0){
             $this->factura->refreshValues();
         }
         RETURN parent::afterSave($insert, $changedAttributes);
     }
    
    public function setTipoTributoIGV(){
        $this->sunat_codtributo=h::sunat()->gRaw('s.05.ttributo')->g('IGV');
        //$this->igv=$this->punit*$this->cant*h::gsetting('general', 'IGV');
        return $this;
    }
    public function setTipoAfectacionEsGravada(){
        $this->sunat_codtipoafectacion= h::sunat()->gRaw('s.07.tafectacion')->g('GONERO');
        return $this;
    }
    public function setTipoAfectacionEsExonerada(){
        $this->sunat_codtipoafectacion= h::sunat()->gRaw('s.07.tafectacion')->g('EXOPONE');
        return $this;
    }
    
    public function setIdChild($parent_id){
        $this->factu_id=$parent_id;
        return $this;
    }
    public function setTipoDocSunat($codocu){
        $this->sunat_tipodoc=$codocu;
        return $this;
    }
    
    public function setItem($item){
        $this->item=$item;
        return $this;
    }
    
     public function isExonerado(){
        return $this->sunat_codtipoafectacion==
               h::sunat()->gRaw('s.07.tafectacion')->g('EXOPONE');
     }
     public function isGravado(){
         //yii::error($this->sunat_codtipoafectacion,__FUNCTION__);
          //yii::error(h::sunat()->gRaw('s.07.tafectacion')->g('GONERO'),__FUNCTION__);
        return $this->sunat_codtipoafectacion==
               h::sunat()->gRaw('s.07.tafectacion')->g('GONERO');
     }
    
    public function refreshValues(){
        $this->punit=round($this->punitgravado/(1+h::gsetting('general','igv')),2);
        $this->pventa=round(($this->punitgravado/(1+h::gsetting('general','igv')))*$this->cant,2);
        $this->igv=round($this->punit*$this->cant*h::gsetting('general','igv'),2);
        $this->totimpuesto=$this->igv+$this->isc;
        if(empty($this->descripcion))$this->descripcion=$this->material->descripcion;
        
        return $this;
    }
    
    
}
