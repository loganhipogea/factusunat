<?php

namespace frontend\modules\com\models;
use common\models\masters\Centros;
use common\models\masters\Almacenes;
use frontend\modules\logi\models\LogiVwStock;
use Yii;

class ComOv extends \common\models\base\modelBase
{
    
    public $despro='';
    public $dateOrTimeFields=[
        'femision'=>self::_FDATE,
    ];
    private $_mapInvoiceFields=[
        'codmon'=>'codmon',
        'rucodni'=>'rucpro',
        'codcen'=>'codcen',
        'tipodoc'=>'sunat_tipodoc',
         'codsoc'=>'codsoc',
         'femision'=>'femision',
         'tipopago'=>'tipopago',
          'codcen'=>'codcen',
          
    ];
            
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%com_ov}}';
    }

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rucodni', 'codcen','tipodoc'], 'required'],
            [['rucodni', 'numero'], 'string', 'max' => 14],
             [['codmon'], 'string', 'max' => 4],
            [['codmon'], 'safe'],
            [['codcen'], 'string', 'max' => 4],
            [['codsoc'], 'string', 'max' => 1],
            [['tipodoc', 'tipopago'], 'string', 'max' => 3],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base.names', 'ID'),
            'rucodni' => Yii::t('base.names', 'Rucodni'),
            'codcen' => Yii::t('base.names', 'Codcen'),
            'codsoc' => Yii::t('base.names', 'Codsoc'),
            'tipodoc' => Yii::t('base.names', 'Tipodoc'),
            'tipopago' => Yii::t('base.names', 'Tipopago'),
            'numero' => Yii::t('base.names', 'Numero'),
        ];
    }

    public function getClipro()
    {
        return $this->hasOne(Centros::className(), ['rucodni' => 'rucpro']);
    }
    
    public function getOv()
    {
        return $this->hasOne(ComOv::className(), ['id' => 'ov_id']);
    }
    
    

    public function getCentro()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }

    public function getDetails()
    {
        return $this->hasMany(ComOvdet::className(), ['ov_id' => 'id']);
    }

   
    public static function find()
    {
        return new ComOvQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if ($insert){
            $this->prefijo=$this->codcen;
            
            $this->numero=$this->correlativo('numero');
        }
        return parent::beforeSave($insert);
    }
    
    private function defaultValues(){
        $this->femision=empty($this->femision)?self::currentDateInFormat():$this->femision;
    }
    
    public function invoice_create(){ 
      if(!$this->invoice_verify_exists()){
          $modelInvoice=New ComFactura();
          $modelInvoice->setAttributes($this->invoice_setFields());
          $transaction=$this->getDb()->beginTransaction();
             if($modelInvoice->save()){
                 $modelInvoice->refresh();
                    $modelInvoice->getDb()->createCommand("update {{%com_ovdet}} set factura_id=:vid where(ov_id=:vid_ov)",
                     [':vid'=>$modelInvoice->id,':vid_ov'=>$this->id])->execute();
                    $transaction->commit();
             }else{
                yii::error('Errores de grabacion',__FUNCTION__);
                yii::error($modelInvoice->getErrors(),__FUNCTION__);
                $transaction->rollBack();
             }
             
           unset($modelInvoice);unset($transaction);
           return true;
      }else{
          return false;
      }
      
       
    }
    
    private function invoice_setFields(){
        $attributes=[];
       foreach($this->_mapInvoiceFields as $field_ov=>$field_invoice){
            $attributes[$field_invoice]=$this->{$field_ov};
       }
       return $attributes;
    }
    
    private function invoice_verify_exists(){
        
       return $this->getDetails()->andWhere(['>','factura_id',0])->exists();
    }
    
    private function invoice_id(){
      return $this->getDetails()->select(['id_factura'])->
              andWhere(['>','factura_id',0])
              ->limit(1)->scalar();       
    }
    
   
    
    public function afterSave($insert, $changedAttributes) {
       // $this->invoice_create();
        return parent::afterSave($insert, $changedAttributes);
    }
   
    
    public function beforeValidate() {
        $this->setAttributes([
    'codsoc' => 'A',
    'codcen' => Centros::find()->one()->codcen,
    //'codal' => Almacenes::find()->one()->codal,
               ]);
        return parent::beforeValidate();
    }
}
