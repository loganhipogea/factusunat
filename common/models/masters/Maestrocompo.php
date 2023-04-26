<?php

namespace common\models\masters;
use common\behaviors\FileBehavior;
use common\models\Sustancia;
use Yii;
use common\helpers\h;
/**

 * @property Ums $codum0
 */
class Maestrocompo extends \common\models\base\modelBase
{
   public $cant_stock=''; //PROPIEDAD PARA SIMULAR UN INGRESO RAPIDO DE STICK EN PUNTO DE VENTA  
    CONST SCE_BATCH='batch';
    CONST SCE_PTO_VENTA='pto_venta';
    CONST SCE_SUSTANCIA='sustancia';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%maestrocompo}}';
    }
 public function behaviors()
{
	return [
		
		'fileBehavior' => [
			'class' => FileBehavior::className()
		],
               
		
	];
}
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion','codtipo','codum'], 'required'], 
             ['sustancia_id', 'safe','except'=>[self::SCE_BATCH,self::SCE_PTO_VENTA]],
          
            [['codart'], 'string', 'max' => 14],
            [['codean'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['marca', 'modelo', 'numeroparte'], 'string', 'max' => 30],
            [['codum', 'peso'], 'string', 'max' => 4],
            [['codart'], 'unique'],
            [['codum'], 'exist', 'skipOnError' => true, 'targetClass' => Ums::className(), 'targetAttribute' => ['codum' => 'codum']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
              'codart' => Yii::t('base.names', 'Codart'),
            'descripcion' => Yii::t('base.names', 'Descripcion'),
            'marca' => Yii::t('base.names', 'Marca'),
            'modelo' => Yii::t('base.names', 'Modelo'),
            'numeroparte' => Yii::t('base.names', 'Numeroparte'),
            'codum' => Yii::t('base.names', 'Codum'),
            'peso' => Yii::t('base.names', 'Peso'),
        ];
    }

    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_BATCH] = [
            'codart', 'descripcion','codum',
            'codtipo', 'codean', 'numeroparte',
            'marca', 'regsan'];
        $scenarios[self::SCE_SUSTANCIA] = [
            'codart', 'descripcion','codum',
            'codtipo', 'codean', 'numeroparte',
            'marca', 'regsan','sustancia_id'];
        $scenarios[self::SCE_PTO_VENTA] = [
            'codart', 'descripcion','codum',
            'codtipo', 'codean', 
            'marca','cant_stock'];        
       return $scenarios;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUm()
    {
        return $this->hasOne(Ums::className(), ['codum' => 'codum']);
    }
    
    public function getSustancia()
    {
        return $this->hasOne(Sustancia::className(), ['id' => 'sustancia_id']);
    }

    public function getKardex()
    {
        return $this->hasMany(\frontend\modules\mat\models\MatKardex::className(), ['codart' => 'codart']);
    }

    public function getStockModels()
    {
        return $this->hasMany(\frontend\modules\mat\models\MatStock::className(), ['codart' => 'codart']);
    }
    
     public function getVales()
    {
        return $this->hasMany(\frontend\modules\mat\models\MatDetvale::className(), ['codart' => 'codart']);
    }
   
    /**
     * {@inheritdoc}
     * @return MaestrocompoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaestrocompoQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        //var_dump($insert);die();
        
        if($insert){
            //$this->prefijo=$this->codtipo;
            if(empty($this->codart))
            $this->codart=$this->correlativo('codart',10,'codtipo');
        }
        return parent::beforeSave($insert);
    }
    
    public function getConversiones(){
         return $this->hasMany(Conversiones::className(), ['codart' => 'codart']);
    }
    
    public function existsUm($codum,$returnModel=true){
       $reg=$this->getConversiones()->andWhere(['codum'=>$codum])->one();
       if(!is_null($reg)){
          return ($returnModel)?$reg:true;
       }else{
          return false; 
       }
    }
    
    public function factorConversion($codum){
      $existe=$this->existsUm($codum,true);
      if($existe){
          return $existe->valor1;
      }else{
          return 1;
      }
    }
    
  private function attributesStock($codal){
      return [
          'codart'=>$this->codart,
          'codcen'=> Almacenes::findOne($codal)->codcen,
          'cant'=>0,
          'um'=>$this->codum,
          'codal'=>$codal,
      ];
      
  }
  /*
   * Registra una fila de stock con cantidad cero
   */ 
  public function createStock($codal){
      $stock= new \frontend\modules\logi\models\Stock();
      $stock->setAttributes($this->attributesStock($codal));
      return $stock->save();      
  }  
  
  public function densidad(){
      return ($this->sustancia_id>0)?$this->sustancia->densidad:0;
  }
  public function peso(){
      return ($this->sustancia_id>0)?$this->sustancia->densidad:0;
  }
  
  
  
  
 }

