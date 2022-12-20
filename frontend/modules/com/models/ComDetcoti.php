<?php

namespace frontend\modules\com\models;
use frontend\modules\com\models\ComCotizacion;
use common\models\masters\Maestrocompo;
use frontend\modules\com\models\ComCoticeco;
use frontend\modules\com\models\ComCotigrupos;
use frontend\modules\mat\models\MatDetpetoferta;
use yii\helpers\ArrayHelper;
use frontend\modules\mat\models\MatVwPetoferta;
use Yii;
/**
 * This is the model class for table "com_detcoti".
 *
 * @property int $id
 * @property int|null $coti_id
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
 * @property ComCotizacione $coti
 */
class ComDetcoti extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'com_detcoti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coti_id','cotigrupo_id','coticeco_id'], 'integer'],
            [['cotigrupo_id','coticeco_id','descripcion','punitcalculado'], 'safe'],
            [['detalle'], 'string'],
            [['cant', 'punit', 'ptotal', 'igv', 'pventa'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
            [['coti_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComCotizacion::className(), 'targetAttribute' => ['coti_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'coti_id' => Yii::t('app', 'Coti ID'),
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

    /**
     * Gets query for [[Coti]].
     *
     * @return \yii\db\ActiveQuery|ComCotizacioneQuery
     */
    public function getCoti()
    {
        return $this->hasOne(ComCotizacion::className(), ['id' => 'coti_id']);
    }
    
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

     public function getCoticeco()
    {
        return $this->hasOne(ComCoticeco::className(), ['id'=>'coticeco_id']);
    }
    
     public function getPartida()
    {
         
        return $this->hasOne(ComCotigrupos::className(), ['id'=>'cotigrupo_id']);
    }
    
    /**
     * {@inheritdoc}
     * @return ComDetcotiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComDetcotiQuery(get_called_class());
    }
    
    public function calculaCosto(){
        
    }
    public function beforeSave($insert) {
        if($this->hasChanged('codart'))
        $this->descripcion=$this->material->descripcion;
        $this->ptotal=$this->punit*$this->cant;
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes) {
        if(in_array('punit',array_keys($changedAttributes))){
            yii::error('SI AGARRO',__FUNCTION__);
            $this->refreshMontos();
        }else{
           yii::error('no AGARRO',__FUNCTION__); 
           yii::error($changedAttributes,__FUNCTION__);
        } 
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function valoresMaterial(){
      
       /*return ArrayHelper::map(
                        \common\models\Sustancia::find()->
                  all(),
                'id','descripcion');*/
       
       
    return ArrayHelper::map(MatVwPetoferta::find()->select(['punit'])
              ->andWhere([
          'codart'=>$this->codart,          
      ])->andWhere([
          '>',
          'punit',
          0
      ])->andWhere([
          '<=',
          'fecha',
          date('Y-m-d')
            ]
              )->limit(3)->all(),'punit','punit'); 
    
  }
  
  private function refreshMontos(){
      $this->coticeco->refreshSubto();
       $this->partida->refreshSubto();
  }
}
