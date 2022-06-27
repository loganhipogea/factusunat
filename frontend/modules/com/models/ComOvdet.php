<?php

namespace frontend\modules\com\models;
use common\models\masters\Centros;
use common\models\masters\Almacenes;
use common\models\masters\Maestrocompo;
use frontend\modules\logi\models\LogiVwStock;
use Yii;


/**
 * This is the model class for table "{{%com_ovdet}}".
 *
 * @property int $id
 * @property int $ov_id
 * @property  string $item
 * @property string|null $codsoc
 * @property string $codcen
 * @property string $codal
 * @property string $codum
 * @property string $codart
 * @property float $punit
 * @property float $pventa
 *
 * @property Almacenes $codal0
 * @property Maestrocompo $codart0
 * @property Centros $codcen0
 * @property ComOv $ov
 */
class ComOvdet extends \common\models\base\modelBase
{
    
    public $subtotal=0;
    public $subtotal_raw=0;
    public $descripcion='';
    public $booleanFields=['activo'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_ovdet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item', 'codcen', 'codal',
                'codum', 'codart', 'punit','cant',
                'pventa'], 'required'],
            [['ov_id'], 'integer'],
            [['item', 'codcen', 'codal',
                'codum', 'codart', 'punit','cant','activo',
                'pventa'], 'safe'],
            [['punit', 'pventa'], 'number'],
            [['item'], 'string', 'max' => 3],
            [['codsoc'], 'string', 'max' => 1],
            [['codcen', 'codal', 'codum'], 'string', 'max' => 4],
            [['codart'], 'string', 'max' => 14],
            [['codal'], 'exist', 'skipOnError' => true, 'targetClass' => Almacenes::className(), 'targetAttribute' => ['codal' => 'codal']],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
            [['ov_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComOv::className(), 'targetAttribute' => ['ov_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'ov_id' => Yii::t('base.names', 'Ov ID'),
            'item' => Yii::t('base.names', 'Item'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'codal' => Yii::t('base.names', 'Codal'),
            'codum' => Yii::t('base.names', 'Codum'),
            'codart' => Yii::t('base.names', 'Codart'),
            'punit' => Yii::t('base.names', 'Punit'),
            'pventa' => Yii::t('base.names', 'Pventa'),
        ];
    }

    /**
     * Gets query for [[Codal0]].
     *
     * @return \yii\db\ActiveQuery|AlmacenesQuery
     */
    public function getCodal0()
    {
        return $this->hasOne(Almacenes::className(), ['codal' => 'codal']);
    }

    /**
     * Gets query for [[Codart0]].
     *
     * @return \yii\db\ActiveQuery|MaestrocompoQuery
     */
     public function getStock()
    {
        return $this->hasOne(LogiVwStock::className(), [
            'codart' => 'codart',
             'codcen' => 'codcen',
             'codal' => 'codal',
            ]);
    }

    /**
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentrosQuery
     */
    public function getCodcen0()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    /**
     * Gets query for [[Ov]].
     *
     * @return \yii\db\ActiveQuery|ComOvQuery
     */
    public function getOv()
    {
        return $this->hasOne(ComOv::className(), ['id' => 'ov_id']);
    }

    /**
     * {@inheritdoc}
     * @return ComOvdetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComOvdetQuery(get_called_class());
    }
    
    public function beforeValidate() {
        $this->setAttributes([
    'item' => '100',
    'codsoc' => 'A',
    'codcen' => Centros::find()->one()->codcen,
    'codal' => Almacenes::find()->one()->codal,
               ]);
     $this->codum=$this->stock->um;
     $this->punit=$this->stock->valor;
        RETURN parent::beforeValidate();
    }
    
    public function beforeSave($insert) {
        
      
        return parent::beforeSave($insert);
    }
}
