<?php

namespace frontend\modules\com\models;
use frontend\modules\com\models\ComCotizacion;
use common\models\masters\ServiciosTarifados;
use common\helpers\h;
use common\models\masters\Tipocambio;
use Yii;

/**
 
 */
class ComDetcotiManoObra extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_detcoti}}';
    }
   public function behaviors() {
        return [
           
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
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
            [['coti_id', 'cotigrupo_id', 'coticeco_id',], 'required'],
            [['coti_id', 'cotigrupo_id', 'coticeco_id', 'detcoti_id', 'detcoti_id_id', 'servicio_id'], 'integer'],
            [['detalle'], 'string'],
            [['cant', 'punit', 'ptotal', 'igv', 'pventa', 'punitcalculado'], 'number'],
            [['item', 'tipo'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 60],
            [['codum'], 'string', 'max' => 4],
            [['flag'], 'string', 'max' => 1],
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
     * @return ComDetcotiManoObraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComDetcotiManoObraQuery(get_called_class());
    }
    
     public function beforeSave($insert) {        
        $this->ptotal=$this->punit*$this->cant;
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes) {
        if(in_array('punit',array_keys($changedAttributes))){
          
            $this->refreshMontos();
        }else{
          
        } 
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function valorTarifa($codmon=null){
        if(is_null($codmon))$codmon= Tipocambio::COD_MONEDA_BASE;
        $mod=ServiciosTarifados::find()->andWhere([
            'id'=>$this->servicio_id,
        ])->one();
        if($this->servicio_id>0 && !is_null($mod) && $mod->codum==$this->codum){
            if($codmon===$this->codmon){
                return $mod->precio;
            }else{//PUEDE SER QUE ESTE EN OTRA MONEDA
                if($cambio=h::tipoCambio($codmon)['compra']>0)
                return $cambio*$mod->precio;
            }
            
        }else{
            return null;
        }
   
    
      }
  
  private function refreshMontos(){
      $this->coticeco->refreshSubto();
       $this->partida->refreshSubto();
  }
}
