<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "{{%com_detcoti}}".
 
 * @property ComCotizaciones $coti
 */
class ComCotiDet extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_detcoti}}';
    }
    
    public $booleanFields=['resumen','mostrar'];
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
            [['coti_id', 'cotigrupo_id', 'coticeco_id', 'detcoti_id', 'detcoti_id_id', 'servicio_id'], 'integer'],
            [['coticeco_id','cant'], 'required'],
            [['detalle'], 'string'],
            [['codcargo','resumen','mostrar','montoneto','coticeco_id'], 'safe'],
            [['cant', 'punit', 'ptotal', 'igv', 'pventa', 'punitcalculado'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
            [['flag'], 'string', 'max' => 1],
            [['codcargo'], 'string', 'max' => 6],
            [['codactivo'], 'string', 'max' => 10],
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
            'punitcalculado' => Yii::t('app', 'Punitcalculado'),
            'cotigrupo_id' => Yii::t('app', 'Cotigrupo ID'),
            'coticeco_id' => Yii::t('app', 'Coticeco ID'),
            'detcoti_id' => Yii::t('app', 'Detcoti ID'),
            'detcoti_id_id' => Yii::t('app', 'Detcoti Id ID'),
            'servicio_id' => Yii::t('app', 'Servicio ID'),
            'flag' => Yii::t('app', 'Flag'),
            'codcargo' => Yii::t('app', 'Codcargo'),
            'codactivo' => Yii::t('app', 'Codactivo'),
        ];
    }

    /**
     * Gets query for [[Coti]].
     *
     * @return \yii\db\ActiveQuery|ComCotizacionesQuery
     */
    public function getCoti()
    {
        return $this->hasOne(ComCotizacion::className(), ['id' => 'coti_id']);
    }
   public function getPartida()
    {
        return $this->hasOne(ComCotigrupos::className(), ['id' => 'cotigrupo_id']);
    }
    /**
     * {@inheritdoc}
     * @return ComCotiDetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotiDetQuery(get_called_class());
    }
    
     public function getDetail()
    {
        return $this->hasMany(ComDetcoti::className(), ['detcoti_id' => 'id']);
    }
    
     public function refreshSubto($update_database=true){
       
        $ums=$this->umsChildColumn();
        if(count($ums)==1){
           $this->codum=$ums[0];
           $this->cant=$this->getDetail()->
                select('sum(cant)')->scalar();
           
        }else{
            
        }
        $this->punit=$this->getDetail()->
                select('avg(punit)')->scalar();
        if($update_database)
        return $this->save();
        return true;
    }
    
    /*Verificar que los hijos tengan la misma unidad de medida
     * 
     * Return :   Array[]
     *      
     */
    private function umsChildColumn(){
       return $this->getDetail()->
         select('codum')->distinct()->column(); 
    }
    
    
    public function subtotal(){
       // yii::error();
        return $this->getDetail()->select('sum(montoneto)')->scalar();
    }
    
   public function refreshMontos(){
       yii::error('refrescandfo los padres',__FUNCTION__);
        $this->montoneto=$this->subtotal();
       
        $this->ptotal=$this->montoneto;
        $this->ptotal=$this->ptotal*(1+$this->coti->cargoPorcentajeAcumulado()/100);
        return $this;
    } 
    
    
    
      public function beforeSave($insert) { 
           yii::error('y pasando por el desencadennare',__FUNCTION__);
        $this->refreshMontos();        
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes) {
         yii::error('y que talco por aqui e',__FUNCTION__);
        if(in_array('montoneto',array_keys($changedAttributes)) ){
            yii::error('sincronizandio en padres',__FUNCTION__);
           $this->sincronizeMontos();
        }else{
           yii::error('se romkpio la cadena en cotidfet',__FUNCTION__);
        } 
        return parent::afterSave($insert, $changedAttributes);
    }
   public function afterDelete() {
        $this->sincronizeMontos();
        return parent::afterDelete();
    }
    private function sincronizeMontos(){
    return $this->partida->refreshMontos()->save();
    }
    
  public function subTotalTotal(){
     return $this->getDetail()->select('sum(ptotal)')->scalar();  
  }
}
