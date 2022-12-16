<?php

namespace frontend\modules\mat\models;
use common\models\masters\Centros;
use common\models\masters\VwSociedades;
use common\models\masters\Clipro;
use common\models\masters\Trabajadores;
use common\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "mat_petoferta".
 */
class MatPetoferta extends \common\models\base\modelBase
{
    public $prefijo='58';
    public $dateorTimeFields=[
     'fecha'=>self::_FDATE,
        
         ];
    public $booleanFields=['igv'];
    const SCE_CLONE='clonar';//Punto de venta ventas rapidas
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mat_petoferta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['codtra','descripcion','codmon'], 'required','except'=>self::SCE_CLONE],
            [['codpro','fecha'], 'required'],
            [['user_id'], 'integer'],
             [['codpro'], 'string', 'max' => 10],
            [['codpro'], 'validate_child','except'=>self::SCE_CLONE],
             [['codpro','codmon','igv','id_relacionado'], 'safe'],
            [['detalle'], 'string'],
            [['numero', 'fecha'], 'string', 'max' => 10],
            [['codcen'], 'string', 'max' => 5],
            [['codsoc'], 'string', 'max' => 1],
            [['codtra'], 'string', 'max' => 6],
            [['estado'], 'string', 'max' => 2],
            [['descripcion'], 'string', 'max' => 40],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
            [['codcen'], 'exist', 'skipOnError' => true, 'targetClass' => Centros::className(), 'targetAttribute' => ['codcen' => 'codcen']],
        ];
    }
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCE_CLONE] = [
                'fecha', 'codpro', 
            ];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'codcen' => Yii::t('app', 'Codcen'),
            'codsoc' => Yii::t('app', 'Codsoc'),
            'fecha' => Yii::t('app', 'Fecha'),
            'codtra' => Yii::t('app', 'Codtra'),
            'user_id' => Yii::t('app', 'User ID'),
            'estado' => Yii::t('app', 'Estado'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
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
     * Gets query for [[Codcen0]].
     *
     * @return \yii\db\ActiveQuery|CentroQuery
     */
    public function getCentro()
    {
        return $this->hasOne(Centros::className(), ['codcen' => 'codcen']);
    }
    
    public function getSociedad()
    {
        return $this->hasOne(VwSociedades::className(), ['codsoc' => 'codsoc']);
    }
     public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

     public function getProveedor()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    /**
     * Gets query for [[MatDetpetoferta]].
     *
     * @return \yii\db\ActiveQuery|MatDetpetofertumQuery
     */
    public function getMatDetpetoferta()
    {
        return $this->hasMany(MatDetpetoferta::className(), ['petoferta_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MatPetofertaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatPetofertaQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->setCorrelativo('numero');
            $this->codsoc= VwSociedades::codsoc();
            $this->codcen= Centros::codcen();
        }
        return parent::beforeSave($insert);
    }
    
    public function ClonePetoferta($otherModel){
        $oldScenario=$this->getScenario();
        $this->setScenario('default');
         
        $fallo=false;
        $this->setAttributes($otherModel->attributes); 
        $this->save();$this->refresh();
        foreach($otherModel->matDetpetoferta as $detalle){
           $modelDetalle=New MatDetpetoferta();
           $modelDetalle->setAttributes($detalle->attributes);
           $modelDetalle->petoferta_id=$this->id;
           if(!$modelDetalle->save()){
              $fallo=true;break;
           }
           unset($modelDetalle);            
        }
        $this->setScenario($oldScenario);
        return  !$fallo;
    }
    
    public function next(){
         return self::find()->select('min(id)')->
                andWhere(['>','id_relacionado',0])->
                andWhere(['id_relacionado'=>$this->id_relacionado])->
                andWhere(['>','id',$this->id])->
                scalar();
        
    }
    public function previous(){
        return self::find()->select('max(id)')->
                andWhere(['>','id_relacionado',0])->
                andWhere(['id_relacionado'=>$this->id_relacionado])->
                andWhere(['<','id',$this->id])->
                scalar();
    }
    
    public function isFirst(){
        return ($this->id_relacionado >0) && is_null($this->previous());
    }
    
    public function isClonable(){
        return $this->isFirst() or is_null($this->id_relacionado);
    }
    
    public function validate_child($attribute,$params){
        if(count($this->matDetpetoferta)==0 && !$this->isNewRecord){
            $this->addError($attribute, yii::t('base.errors','Este registro no tiene hijos'));
        }
    }
    
    public function total(){
        return $this->getMatDetpetoferta()->select('sum(pventa)')->scalar();
    }
    public function igv(){
        return $this->getMatDetpetoferta()->select('sum(igv)')->scalar();
    }
}
