<?php

namespace frontend\modules\com\models;
use common\models\masters\Centros;
use common\models\masters\Almacenes;
use common\models\masters\Maestrocompo;
use frontend\modules\logi\models\LogiVwStock;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%com_factudet}}".
 *
 * @property int $id
 * @property int|null $factu_id
 * @property string|null $item
 * @property string|null $codsoc
 * @property string|null $codcen
 * @property string|null $codum
 * @property string|null $codart
 * @property float|null $punit
 * @property float|null $pventa
 * @property float|null $cant
 * @property string|null $descripcion
 * @property float|null $igv
 * @property float|null $descuento
 * @property string|null $sunat_codtipoprecio
 * @property string|null $sunat_codtributo
 * @property string|null $sunat_codtipoafectacion
 *
 * @property Maestrocompo $codart0
 * @property Centro $codcen0
 */
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
            [['punit', 'cant',],'required'],
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
            'punit' => Yii::t('base.names', 'Punit'),
            'pventa' => Yii::t('base.names', 'Pventa'),
            'cant' => Yii::t('base.names', 'Cant'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'igv' => Yii::t('base.names', 'Igv'),
            'descuento' => Yii::t('base.names', 'Descuento'),
            'sunat_codtipoprecio' => Yii::t('base.names', 'Sunat Codtipoprecio'),
            'sunat_codtributo' => Yii::t('base.names', 'Sunat Codtributo'),
            'sunat_codtipoafectacion' => Yii::t('base.names', 'Sunat Codtipoafectacion'),
        ];
    }

    
    /*public function getStock()
    {
        return $this->hasOne(LogiVwStock::className(), [
            'codart' => 'codart',
             'codcen' => 'codcen',
             'codal' => 'codal',
            ]);
    }*/
    /**
     * Gets query for [[Codart0]].
     *
     * @return \yii\db\ActiveQuery|MaestrocompoQuery
     */
    public function getCodart0()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentroQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centro::className(), ['codcen' => 'codcen']);
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
        $this->pventa=$this->punit*$this->cant;
        if($this->isInvoice())
        $this->igv=$this->pventa*h::gsetting ('general','igv');
        
        return parent::beforeSave($insert);
    }
}
