<?php

namespace frontend\modules\com\models;

use Yii;

/**
 * This is the model class for table "com_cotigrupos".
 *
 * @property int $id
 * @property string|null $descripartida
 * @property string|null $calificacion
 * @property float|null $total
 * @property string|null $item
 * @property int|null $coti_id
 */
class ComCotigrupos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'com_cotigrupos';
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
            [['total'], 'number'],
            [['descripartida'], 'required'],
            [['coti_id'], 'integer'],
               [['montoneto'], 'safe'],
            [['descripartida'], 'string', 'max' => 40],
            [['calificacion'], 'string', 'max' => 1],
            [['item'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'descripartida' => Yii::t('app', 'Descripartida'),
            'calificacion' => Yii::t('app', 'Calificacion'),
            'total' => Yii::t('app', 'Total'),
            'item' => Yii::t('app', 'Item'),
            'coti_id' => Yii::t('app', 'Coti ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ComCotigruposQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ComCotigruposQuery(get_called_class());
    }
    public function getDetail()
    {
        return $this->hasMany(ComDetcoti::className(), ['cotigrupo_id' => 'id']);
    }
     public function getCoti() {
        return $this->hasOne(ComCotizacion::className(), ['id' => 'coti_id']);
    }
    
     public function getDetailPadres()
    {
        return $this->hasMany(ComCotiDet::className(), ['cotigrupo_id' => 'id']);
    }
    public function refreshSubto($update_database=true){
        $this->total=$this->getDetail()->
         select('sum(ptotal)')->scalar();
        if($update_database)
        return $this->save();
        return true;
    }
    
    public function beforeSave($insert) {
        if($insert)
        $this->item=$this->numeroItem();
        $this->refreshMontos();
        return parent::beforeSave($insert);
    }
     public function afterDelete() {
        $this->sincronizeMontos();
        return parent::afterDelete();
    }
    
   public function afterSave($insert, $changedAttributes) {
        if(in_array('montoneto',array_keys($changedAttributes)) or in_array('total',array_keys($changedAttributes))){
           $this->sincronizeMontos();
           yii::error('sicornizandoi en grupos',__FUNCTION__);
        }else{
            yii::error('se romkpio la cadena en grupos',__FUNCTION__);
        } 
        return parent::afterSave($insert, $changedAttributes);
    } 
    private function numeroItem(){       
       $max= $this->coti->getPartidas()->count()+0;
       
       $max+=1;
       $item= str_pad($max, 3,'0',STR_PAD_LEFT);
       return $item;
    }
    
    public function subtotal(){
        return $this->getDetailPadres()->select('sum(montoneto)')->scalar();
    }
    public function subTotaltTotal(){
        return $this->getDetailPadres()->select('sum(ptotal)')->scalar();
    }
    public function refreshMontos(){
        $this->montoneto=$this->subtotal();
       
        $this->total=$this->subTotaltTotal();
        return $this;
    } 
  
    private function sincronizeMontos(){
          return   $this->coti->retiraComportamientoLog()->refreshMontos()->save();
    }
    
    public function retiraComportamientoLog(){
      $this->detachBehavior('auditoriaBehavior');
      return $this;
  }
}
