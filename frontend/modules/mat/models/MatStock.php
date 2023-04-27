<?php

namespace frontend\modules\mat\models;
use frontend\modules\mat\models\MatDetreq;
use common\models\masters\Maestrocompo;
use Yii;

/**
 * This is the model class for table "{{%mat_stock}}".
 *
 * @property int $id
 * @property string $codart
 * @property string $cant
 * @property string $um
 * @property string $ubicacion
 * @property string $cantres
 * @property string $codal
 * @property string $valor
 * @property string $lastmov
 *
 * @property Maestrocompo $codart0
 */
class MatStock extends \common\models\base\modelBase
{
    
    const SEMAFORO_EXCESO='E'; //Exceso de stock
    const SEMAFORO_OK='G';
    const SEMAFORO_CUIDADO='Y';
    const SEMAFORO_PELIGRO='R';//Ruptura de stock
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_stock}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codart','um','cant'], 'required'],
            [['cant', 'cantres', 'valor'], 'number'],
            [['codart', 'ubicacion'], 'string', 'max' => 14],
             [['um'], 'valida_um_base'],
             [['valor_unit','cant_disp','semaforo','valor','codal'], 'safe'],
            [['um', 'codal'], 'string', 'max' => 4],
            [['lastmov'], 'string', 'max' => 10],
            [['codart','codal'], 'unique','targetAttribute'=>['codart','codal']],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codart' => Yii::t('app', 'Codart'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'ubicacion' => Yii::t('app', 'Ubicacion'),
            'cantres' => Yii::t('app', 'Cantres'),
            'codal' => Yii::t('app', 'Codal'),
            'valor' => Yii::t('app', 'Valor'),
            'lastmov' => Yii::t('app', 'Lastmov'),
        ];
    }
 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

   public function getMatalmacen()
    {
        return $this->hasOne(MatMatAlmacen::className(), ['codart' => 'codart','codal'=>'codal']);
    }
     /*public function getKardex() {
        return $this->hasMany(MatKardex::className(), ['stock_id' => 'id']);
    }*/
    /**
     * {@inheritdoc}
     * @return MatStockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatStockQuery(get_called_class());
    }
    
    
    /*No se puede registrar un stock con la unidad de medida
     * difrente a la unidad  base
     */
    
    public function valida_um_base(){
        if(!$this->material->codum ==$this->um)
        $this->addError('um',yii::t('base.errors','Esta unidad de medida no es la base'));
    }
    
    public function actualiza(){
        
    }
    
    private function resolveStock(){
         $this->cant=((is_null($this->cant_disp))?0:$this->cant_disp)+((is_null($this->cantres))?0:$this->cantres);        
         if($this->hasChanged('valor')){
             if($this->cant==0){
                 $this->valor=0;$this->valor_unit=0;
             }else{
                 $this->valor_unit=$this->valor/$this->cant;
             }
             
         }  
    }
    /*
     * Si se trata de materiales
     * con contrl de reorden
     */
     private function resolveSemaforo(){
        if(!is_null($this->semaforo)){
            $this->semaforo=$this->resolveSemaforo();
        }
    }
    
    
    private function calificaSemaforo($cant){
        
      
        if($this->cantres >0){
           $cantidad=$this->cant_disp; 
        }else{
          $cantidad=$this->cant;   
        }
        $propiedades=$this->matalmacen;
     if(is_null( $propiedades)){
      if($cantidad > $propiedades->ceconomica)
         return self::SEMAFORO_EXCESO;
      elseif($cantidad > $propiedades->creorden)
         return self::SEMAFORO_OK;
      elseif($cantidad > $propiedades->crepo)
         return self::SEMAFORO_CUIDADO;
       else
         return self::SEMAFORO_PELIGRO;       
        
       }else{
         return null;  
       }
   
     
    }
    public function beforeSave($insert) {
        yii::error($this->attributes,__FUNCTION__);
        $this->resolveStock();
         yii::error($this->attributes,__FUNCTION__);
        $this->resolveSemaforo();
        return parent::beforeSave($insert);
    }
    
    
   
    
}
