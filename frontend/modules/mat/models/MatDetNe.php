<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
use common\models\masters\Centros;
use common\models\masters\VwSociedades;
use Yii;

/**
 * This is the model class for table "{{%mat_detguia}}".
 *
 * @property int $id
 * @property int $guia_id
 * @property string|null $item
 * @property string|null $codum
 * @property float $cant
 * @property string|null $codart
 * @property string|null $codaf
 * @property string|null $serie
 * @property string|null $descripcion
 * @property string|null $detalle
 */
class MatDetNe extends \common\models\base\modelBase
{
   
   const EST_ACTIVO='1' ;
   const EST_ANULADO='0';
    
    
    public $booleanFields=['rotativo','activo'];
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detguia}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guia_id', 'cant','descripcion'], 'required'],
            [['guia_id'], 'integer'],
            [['cant'], 'number'],
            [['rotativo','estadomaterial','activo'], 'safe'],
            [['detalle'], 'string'],
            [['item'], 'string', 'max' => 3],
            [['codum'], 'string', 'max' => 4],
            [['codart', 'codaf'], 'string', 'max' => 14],
            [['serie'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 80],
        ];
    }

    
     public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'guia_id' => Yii::t('app', 'Guia ID'),
            'item' => Yii::t('app', 'Item'),
            'codum' => Yii::t('app', 'Codum'),
            'cant' => Yii::t('app', 'Cant'),
            'codart' => Yii::t('app', 'Codart'),
            'codaf' => Yii::t('app', 'Codaf'),
            'serie' => Yii::t('app', 'Serie'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatDetGuiaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatDetNeQuery(get_called_class());
    }
    
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getNe()
    {
        return $this->hasOne(MatNe::className(), ['id' => 'guia_id']);
    }
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }
    
     public function beforeSave($insert) {
        IF($insert){            
            $this->setActivo()->item= $this->nextItem();
                      
                  }         
        RETURN parent::beforeSave($insert);
    }
    
    private function nextItem(){
      return str_pad(($this->find()->andWhere(['guia_id'=>$this->guia_id])->count()+1).'',3,'0',STR_PAD_LEFT);
    }
    
    public function setInactivo(){
        $this->activo=self::EST_ANULADO;
       return $this;
    }
    
    public function setActivo(){
        $this->activo=self::EST_ACTIVO;
       return $this;
    }
    
    public function isActivo(){
        return $this->activo==self::EST_ACTIVO;
    }
    
    /*
     * ESTA FUNCION CREA UNA ORDEN AUTOMATICAMENTE
     * RELACIONANDO EL INGRESO CON EL CAMPO ID
     */
    public function createOp(){
        if(is_null(\frontend\modules\op\models\OpOs::findOne(['detgui_id'=>$this->id])) and 
            !$this->isNewRecord){
        \frontend\modules\op\models\OpOs::firstOrCreateStatic(
                [
                   'detgui_id'=>$this->id,
                    'fechaini'=>$this->currentDateInFormat(),
                    'descripcion'=>$this->descripcion,
                    'codart'=>$this->codart,
                    'codpro'=> VwSociedades::codpro(),
                    'proc_id'=> \frontend\modules\op\models\OpProcesos::find()->andWhere(['>', 'id', 0])->one()->id,
                    
                ],
                null,
                ['detgui_id'=>$this->id],
                false);        
                
            }
    }
    
   public function afterSave($insert, $changedAttributes) {
       
       if($this->rotativo)$this->createOp();
       return parent::afterSave($insert, $changedAttributes);
   } 
    
}
