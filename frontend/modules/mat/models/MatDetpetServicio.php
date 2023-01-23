<?php

namespace frontend\modules\mat\models;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%mat_detpetoferta}}".
 *
 * @property int $id
 * @property int|null $petoferta_id
 * @property string|null $item
 * @property string|null $tipo tipo material o servicio
 * @property string|null $codart
 * @property string|null $descripcion
 * @property string|null $detalle
 * @property string|null $codum
 * @property float|null $cant
 * @property float|null $punit
 * @property float|null $ptotal
 * @property float|null $igv
 * @property float|null $pventa
 *
 * @property MatPetofertum $petoferta
 */
class MatDetpetServicio extends \common\models\base\modelBase
{
    
    Const FLAG_SERVICIO='S';
    Const FLAG_MATERIAL='M';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detpetoferta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['codum','descripcion','pventa'], 'required'],
            [['servicio_id','flag','codart'], 'safe'],
            [['petoferta_id'], 'integer'],
            [['detalle'], 'string'],
            [['cant', 'punit', 'ptotal', 'igv', 'pventa'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
           // [['petoferta_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatPetofertum::className(), 'targetAttribute' => ['petoferta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'petoferta_id' => Yii::t('app', 'Petoferta ID'),
            'item' => Yii::t('app', 'Item'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codart' => Yii::t('app', 'Codart'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'codum' => Yii::t('app', 'Codum'),
            'cant' => Yii::t('app', 'Cant'),
            'punit' => Yii::t('app', 'Punit'),
            'ptotal' => Yii::t('app', 'Ptotal'),
            'igv' => Yii::t('app', 'Igv'),
            'pventa' => Yii::t('app', 'Pventa'),
        ];
    }

   public function getPetoferta()
    {
        return $this->hasOne(MatPetoferta::className(), ['id' => 'petoferta_id']);
    }
    
   public function getServicio()
    {
        return $this->hasOne(\common\models\masters\ServiciosTarifados::className(), ['id' => 'servicio_id']);
    }
    /**
     * {@inheritdoc}
     * @return MatDetpetServicioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetpetServicioQuery(get_called_class());
    }
    
     public function beforeSave($insert) {
        if($insert)$this->flag=self::FLAG_SERVICIO;
        $this->codart=$this->servicio->codserv;
        $this->resolveMontos();
        
        return parent::beforeSave($insert);
    }
    
    private function resolveMontos(){
        if($this->petoferta->igv){
         if(!empty($this->pventa)){
             $this->ptotal=$this->pventa/(1+h::gsetting('general', 'igv'));
             $this->igv=$this->pventa-$this->ptotal;
             }
        }else{
            if(!empty($this->pventa)){
             $this->ptotal=$this->pventa;
            } 
        }
        $this->punit=empty($this->pventa)?:$this->pventa/$this->cant;
    }
    
   public function isMaterial(){
       return ($this->flag===self::FLAG_MATERIAL);
   }
     
}
