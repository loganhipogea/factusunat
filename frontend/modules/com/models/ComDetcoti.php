<?php
namespace frontend\modules\com\models;
use frontend\modules\com\models\ComCotizacion;
use common\models\masters\Maestrocompo;
use frontend\modules\com\models\ComCoticeco;
use frontend\modules\com\models\ComCotigrupos;
use frontend\modules\mat\models\MatDetpetoferta;
use yii\helpers\ArrayHelper;
use frontend\modules\mat\models\MatVwPetoferta;
use common\models\masters\Tipocambio;
use Yii;
/**roperty ComCotizacione $coti
 */
class ComDetcoti extends \common\models\base\modelBase
{
    const SCE_HERRAMIENTAS='SH';
    const SCE_SERVICIO='SS';
    const SCE_MANO_OBRA='SM';
    
    
    public static function tableName()
    {
        return 'com_detcoti';
    }
    public function behaviors() {
        return [
           
           /* 'fileBehavior' => [
                'class' => FileBehavior::className()
            ],*/
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
            
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coti_id','cotigrupo_id','coticeco_id'], 'integer'],
            
             [['codactivo','cant','codum'], 'required','on'=>self::SCE_HERRAMIENTAS],
            [['servicio_id','cant','codum'], 'required','on'=>self::SCE_SERVICIO],
             [['codcargo','cant','codum'], 'required','on'=>self::SCE_MANO_OBRA],
            
            
            [['cotigrupo_id','coticeco_id','descripcion','punitcalculado'], 'safe'],
            [['detalle'], 'string'],
            [['tipo','codcargo','codactivo','servicio_id','montoneto'  ], 'safe'],
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
           'punitcalculado' => Yii::t('app', 'P. Aut'),
            'ptotal' => Yii::t('app', 'Ptotal'),
            'igv' => Yii::t('app', 'Igv'),
            'pventa' => Yii::t('app', 'Pventa'),
        ];
    }

    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_HERRAMIENTAS] = [
            'codactivo', 'descripcion','codum',
            'cant', 'punit', 'ptotal','punitcalculado',
            'cotigrupo_id', 'coticeco_id', 'detcoti_id',
             'detcoti_id_id','servicio_id','tipo'
            ];
        $scenarios[self::SCE_SERVICIO] = [
              'descripcion','codum',
            'cant', 'punit', 'ptotal','punitcalculado',
            'cotigrupo_id', 'coticeco_id', 'detcoti_id',
             'detcoti_id_id','servicio_id','tipo'
            ];
        $scenarios[self::SCE_MANO_OBRA] = [
             'codcargo', 'codum',
            'cant', 'punit', 'ptotal','punitcalculado',
            'cotigrupo_id', 'coticeco_id', 'detcoti_id',
             'detcoti_id_id','servicio_id','tipo'
            ];        
       return $scenarios;
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
    
     public function getActivo()
    {
         
        return $this->hasOne(\frontend\modules\mat\models\MatActivos::className(), ['codigo'=>'codactivo']);
    }
    
     public function getCargo()
    {
         
        return $this->hasOne(\common\models\masters\Cargos::className(), ['codcargo'=>'codcargo']);
    }
    
     public function getServicio()
    {
         
        return $this->hasOne(\common\models\masters\ServiciosTarifados::className(), ['id'=>'servicio_id']);
    }
    
     public function getPadre()
    {
         
        return $this->hasOne(ComCotiDet::className(), ['id'=>'detcoti_id']);
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
        $this->resolveCodes();
        $this->resolvePrecioUnitario();
        $this->refreshMontos();
        //$this->refreshMontos();
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes) {
        if(in_array('punit',array_keys($changedAttributes)) or in_array('cant',array_keys($changedAttributes))){
            yii::error('sincronizando en detalles',__FUNCTION__);
           $this->sincronizeMontos();
           
        }else{
          
           yii::error('se romkpio la cadena en detcoti',__FUNCTION__);
        
        } 
        return parent::afterSave($insert, $changedAttributes);
    }
    public function afterDelete() {
        $this->sincronizeMontos();
        return parent::afterDelete();
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
  private function isChildRecord(){
      return $this->detcoti_id >0;
  }
  private function sincronizeMontos(){
      //yii::error('sincornizando en detalles.. pasa a los padres refresh monto()',__FUNCTION__);
    //yii::error($this->padre->refreshMontos()->save());
   // yii::error($this->padre->geterrors());
      $this->padre->retiraComportamientoLog()->refreshMontos()->save();
  }
  
  public function resolveScenario(){
      $tipo=$this->tipo;
        switch ($tipo) {
    case 'M':
        $this->setScenario('default');
        break;
    case 'H':
        $this->setScenario(self::SCE_HERRAMIENTAS);
        break;
    case 'S':
        $this->setScenario(self::SCE_SERVICIO);
        break;
    case 'T':
        $this->setScenario(self::SCE_MANO_OBRA);
        break;
        }
  }
  
  
  public function valorUnitario(){
    $tipo=$this->tipo;
        switch ($tipo) {
    case 'M':
        
        break;
    case 'H':
        
        break;
    case 'S':
        
        break;
    case 'T':
        
        break;
        }  
     
  }
  
  //Resuelve que codigo colocar segun el tipo de 
  public function resolveCodes(){
      $tipo=$this->tipo;
        switch ($tipo) {
    case 'M':
        if($this->hasChanged('codart'))
        $this->descripcion=$this->material->descripcion;
        break;
    case 'H':
         if($this->hasChanged('codactivo'))
        $this->descripcion=$this->activo->descripcion;
        break;
    case 'S':
        if($this->hasChanged('servicio_id')){
             $this->codart=$this->servicio->codserv;
             $this->descripcion=$this->servicio->descripcion;
        }
       
        
        break;
    case 'T':
        if($this->hasChanged('codcargo'))
        $this->descripcion=$this->cargo->descricargo;
        break;
        }
  }
  
  public function precioUnitarioMaterial($codmon=Tipocambio::COD_MONEDA_BASE){
      return MatVwPetoferta::valor($this->codart,$codmon);
  }
  
  public function precioUnitarioManoObra($codmon=Tipocambio::COD_MONEDA_BASE){
      return $this->cargo->valor($codmon);
  }
  
  public function precioUnitarioHerramienta($codmon=Tipocambio::COD_MONEDA_BASE){
      return $this->activo->costoHora($codmon);
  }
  
  public function precioUnitarioServicio($codmon=Tipocambio::COD_MONEDA_BASE){
      return $this->servicio->valorTarifa($codmon);
  }
  
 public function resolvePrecioUnitario(){
    $tipo=$this->tipo;
        switch ($tipo) {
    case 'M':
         $this->punitcalculado=$this->precioUnitarioMaterial($this->coti->codmon);
        break;
    case 'H':
         $this->punitcalculado=$this->precioUnitarioHerramienta($this->coti->codmon); 
         break;
    case 'S':
        $this->punitcalculado=$this->precioUnitarioServicio($this->coti->codmon);
         
         break;
    case 'T':
          $this->punitcalculado=$this->precioUnitarioManoObra($this->coti->codmon);
         
         $this->punit=$this->punitcalculado;
        break;
        }  
 } 
 
    public function refreshMontos(){
        $this->montoneto=$this->punit*$this->cant;
        $this->ptotal=$this->montoneto;
        $this->ptotal=$this->ptotal*(1+$this->coti->cargoPorcentajeAcumulado()/100);
        
        return $this;
    }
 
}
