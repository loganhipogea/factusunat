<?php

namespace common\models\masters;
use common\models\base\modelBase;
use common\helpers\h;
use common\helpers\BaseHelper;
use Yii;
use Carbon\Carbon;

/**
 * This is the model class for table "{{%trabajadores}}".
 *
 * @property string $codigotra
 * @property string $ap
 * @property string $am
 * @property string $nombres
 * @property string $dni
 * @property string $ppt
 * @property string $pasaporte
 * @property string $codpuesto
 * @property string $cumple
 * @property string $fecingreso
 * @property string $domicilio
 * @property string $telfijo
 * @property string $telmoviles
 * @property string $referencia
 */
class Trabajadores extends modelBase implements \common\interfaces\PersonInterface
{
   
   public $nombrecompleto;
   public $persona;
    
     
    public function behaviors()
{
	return [
		
		'fileBehavior' => [
			'class' => \nemmo\attachments\behaviors\FileBehavior::className()
		],
             'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
	];
}
 
    
     public function init(){
         $this->prefijo='76';
         $this->dateorTimeFields=['fecingreso'=>self::_FDATE,'cumple'=>self::_FDATE];
            return parent::init();
     }
     
     
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trabajadores}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ap', 'am', 'nombres', 'codpuesto', 'fecingreso','cumple'], 'required'],
            [['cumple', 'fecingreso'], 'validateFechas'],
            [['codigotra'], 'string', 'max' => 6],
            [['ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['dni', 'ppt', 'pasaporte', 'cumple', 'fecingreso'], 'string', 'max' => 10],
            [['codpuesto'], 'string', 'max' => 3],
            [['domicilio'], 'string', 'max' => 73],
            [['telfijo'], 'string', 'max' => 13],
            [['telmoviles', 'referencia'], 'string', 'max' => 30],
            [['codigotra'], 'unique'],
             [['dni'], 'unique'],
            ['dni','match',
                 'pattern'=>h::settings()->get('general','formatoDNI'),
                 'message'=>yii::t('base.errors','El {field} no coincide con el formato ',['field'=>$this->getAttributeLabel('dni')])
                
                 ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigotra' => Yii::t('base.names', 'Código'),
            'ap' => Yii::t('base.names', 'A Pat'),
            'am' => Yii::t('base.names', "A Mat"),
            'nombres' => Yii::t('base.names', 'Nombres'),
            'dni' => Yii::t('base.names', 'Doc. Id.'),
            'ppt' => Yii::t('base.names', 'PPT'),
            'pasaporte' => Yii::t('base.names', 'Pasaporte'),
            'codpuesto' => Yii::t('base.names', 'Cargo'),
            'cumple' => Yii::t('base.names', 'F Nac.'),
            'fecingreso' => Yii::t('base.names', 'F. ingreso'),
            'domicilio' => Yii::t('base.names', 'Dirección'),
            'telfijo' => Yii::t('base.names', 'Tel Fijo'),
            'telmoviles' => Yii::t('base.names', 'Movil'),
            'referencia' => Yii::t('base.names', 'Referencias'),
        ];
    }

    
    public function validateFechas($attribute, $params)
    {
      // $this->toCarbon('fecingreso');
       //$this->toCarbon('cumple');
       //self::CarbonNow();
       //var_dump(self::CarbonNow());
        
       if($this->toCarbon('fecingreso')->greaterThan(self::CarbonNow())){
            $this->addError('fecingreso', yii::t('base.errors','La fecha  {campo} es una fecha futura',
                    ['campo'=>$this->getAttributeLabel('fecingreso')]));
       }
      // if(self::CarbonNow()->diffInYears( $this->toCarbon('cumple')) < 18){
       if($this->age() < 18){
            $this->addError('cumple', yii::t('base.errors','Es muy joven para ser trabajador',
                    ['campo'=>$this->getAttributeLabel('cumple')]));
       }
        /*if (!in_array($this->$attribute, ['USA', 'Indonesia'])) {*/
           
        /*}*/
    }
 
    
    public function beforeSave($insert) {
        if($insert)
        $this->codigotra=$this->correlativo('codigotra');
        
       return parent::beforeSave($insert);
    }
    
    public function afterFind(){
        $this->nombrecompleto=$this->fullName();
        parent::afterFind();
    }

      public function name(){
          return $this->nombres;
        }  
  public function lastName(){
          return $this->ap;
        }  
        
        
  public function age(){
          return $this->toCarbon('cumple')->age; //no hay fecha de nacimiento
        }  
        
        
  public function docsIdentity(){
         return [
             h::AdocId()[BaseHelper::DOC_DNI]=>$this->dni,
              h::AdocId()[BaseHelper::DOC_PASAPORTE]=>$this->pasaporte,
              h::AdocId()[BaseHelper::DOC_PPT]=>$this->ppt,
             // h::AdocId()[BaseHelper::DOC_BREVETE]=>$this->ppt,
             ];
        }  
        
        
  public function address(){
          return $this->domicilio;
        } 
        
        
  public function fenac(){
 return $this->toCarbon('cumple'); 
        }  
        
        
     public function IsBirthDay(){
         $hoy=Carbon::now();
 return $hoy->isBirthday($this->toCarbon('cumple')); 
        }  
        
        
        
     public function fullName($asc=TRUE,$ucase=true,$delimiter=' '){       
         $strname=($asc)?$this->nombres.' '.$this->ap.' '.$this->am:$strname= $this->ap.' '.$this->am.' '.$this->nombres;
         $strname= ($ucase)?\yii\helpers\StringHelper::mb_ucwords($strname):$strname;
       return str_replace(' ',$delimiter, $strname);
     }
    
     
    /**
     * {@inheritdoc}
     * @return CliproQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrabajadoresQuery(get_called_class());
    } 
    
    
     public function getTarifas()
    {
        return $this->hasMany(\frontend\modules\op\models\OpTarifaHombre::className(), ['codtra' => 'codigotra']);
    }
    
    /*public function hasTarifa(){
        return ($this->getTarifas()->exists())?true:false;
    }*/
     public function tarifaId(){
         
        return $this->getTarifas()->select(['id'])->andWhere(['activo'=>'1'])->scalar();
    }
     
}