<?php

namespace common\models\masters;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%clipro}}".
 *
 * @property string $codpro
 * @property string $despro
 * @property string $rucpro
 * @property string $telpro
 * @property string $web
 * @property string $deslarga
 */
class Clipro extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public $prefijo='37';
    public $withAudit=true;
    public $fecha;
    public $booleanFields=['socio'];
    //public $booleanFields=[''];
    public static function tableName()
    {
        return '{{%clipro}}';
    }
    
    
    
    
    public function behaviors()
         {
                return [
		
		/*'fileBehavior' => [
			'class' => '\frontend\modules\attachments\behaviors\FileBehaviorAdvanced' 
                               ],*/
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
  public static function patternDNI_RUC(){
      $regDni= h::gsetting('general','formatoDNI');
      $regRuc= h::gsetting('general','formatoRUC');
      yii::error(strrev(substr(strrev($regDni),1)).'|'.substr($regRuc,1),__FUNCTION__);
    return strrev(substr(strrev($regDni),1)).'|'.substr($regRuc,1);
  }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
       
        return [
            [['despro', 'rucpro'], 'required'],
            [['deslarga'], 'string'],
            [['cci', 'codbanco','cuenta','deslarga','alias','socio'], 'safe'],
            //[['rucpro'], 'match', 'pattern'=>h::gsetting('general','formatoDNI')],
            [['rucpro'], 'match', 'pattern'=>self::patternDNI_RUC()],
            [['despro'], 'string', 'max' => 60],
            [['rucpro', 'telpro'], 'string', 'max' => 15],
            [['web'], 'string', 'max' => 85],
             ['rucpro', 'unique'],
             ['rucpro','match',
                 'pattern'=>h::settings()->get('general','formatoRUC'),
                 'message'=>yii::t('base.errors','The {field} doesn\'t match with format',['field'=>$this->getAttributeLabel('rucpro')])
                
                 ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codpro' => Yii::t('base.names', 'Code'),
            'despro' => Yii::t('base.names', 'Description'),
            'rucpro' => Yii::t('base.names', 'Record Contr'),
            'telpro' => Yii::t('base.names', 'Phone Number'),
            'web' => Yii::t('base.names', 'web'),
            'deslarga' => Yii::t('base.names', 'Long Text'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CliproQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CliproQuery(get_called_class());
    }
    
     public function getDirecciones() {
        return $this->hasMany(Direcciones::className(), ['codpro' => 'codpro']);
    }
    public function getContactos() {
        return $this->hasMany(Contactos::className(), ['codpro' => 'codpro']);
    }
    public function getMateriales() {
        return $this->hasMany(Maestroclipro::className(), ['codpro' => 'codpro']);
    }
    public function getObjectos() {
        return $this->hasMany(ObjetosCliente::className(), ['codpro' => 'codpro']);
    }
    public function getCentros() {
        return $this->hasMany(Centros::className(), ['codpro' => 'codpro']);
    }
    public function beforeSave($insert) {
        //var_dump($insert);die();
        if($insert){
            $this->socio=false;
            $this->codpro=$this->correlativo('codpro');
        }
        return parent::beforeSave($insert);
    }
    
   
    public function convierteSocio($socio=true){
        $this->socio=$socio;
        if(!$socio && !$this->canRevertSociedad())
        $this->addError ('socio',yii::t('base.errors','Esta sociedad ya tiene datos relacionados'));
        return $this->save();
    }
    
    private function canRevertSociedad(){
        return($this->getCentros()->count()>0)?false:true;
    }
}
