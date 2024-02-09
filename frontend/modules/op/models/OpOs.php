<?php

namespace frontend\modules\op\models;
use common\models\masters\Trabajadores;
use common\models\masters\Clipro;
use Yii;
use common\behaviors\CodocuBehavior;
use common\interfaces\CosteoInterface;
use common\models\masters\VwSociedades;
use frontend\modules\mat\models\MatDetNe;
/**
 * This is the model class for table "{{%op_os}}".
 *
 * @property int $id
 * @property int $proc_id
 * @property string $numero
 * @property string $fechaprog
 * @property string $fechaini
 * @property string $codtra
 * @property string $codpro
 * @property string $descripcion
 * @property string $tipo
 * @property string $codestado
 * @property string $textocomercial
 * @property string $textointerno
 * @property string $textotecnico
 */
class OpOs extends \common\models\base\modelBase 
implements CosteoInterface,
        \frontend\modules\mat\interfaces\DocRelacionadoValeInterface
{
    
    CONST TYPE_ESTRUCTURAL_EQUIPO='A';
    CONST TYPE_COMPONENTE_ROTATIVO='B';
    CONST TYPE_COMPONENTES_VARIOS='C';
    CONST TYPE_ESTRUCTURA_DESCONOCIDA='D';
    
    CONST LUGAR_TALLER='T';
    CONST LUGAR_PLANTA='P';
    
    /* public $dateorTimeFields = [
        'fechaprog' => self::_FDATE,
        'fechaini' => self::_FDATE,
       
    ];
     */
      
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_os}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_id','tipoes'], 'required'],
            
            /*Validando la obligatoriedad de los campos codigos según el tipo*/
            
            [['tipoes'], 'validate_codes'],
            
           
            
            
             [['item','codcen','detgui_id','codart','orden','ot',
                 'finprog','fin','codest','avance','codactivo','codcencli','serie','cant','tipoes'], 'safe'],
            [['proc_id'], 'integer'],
            [['textocomercial', 'textointerno', 'textotecnico','tipoes'], 'string'],
            [['numero'], 'string', 'max' => 10],
            [['fechaprog', 'fechaini'], 'string', 'max' => 10],
            [['codtra',], 'string', 'max' => 6],
            [['codpro',], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 40],
            [['tipo'], 'string', 'max' => 1],
            [['codestado'], 'string', 'max' => 2],
        ];
    }

    
    public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'numero' => Yii::t('app', 'Numero'),
            'fechaprog' => Yii::t('app', 'Fechaprog'),
            'fechaini' => Yii::t('app', 'Fechaini'),
            'codcen' => Yii::t('app', 'Local'),
            'codcencli' => Yii::t('app', 'Destino'),
            'codtra' => Yii::t('app', 'Codtra'),
            'codpro' => Yii::t('app', 'Codpro'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'tipo' => Yii::t('app', 'Tipo'),
           'tipoes' => Yii::t('app', 'Tipo'),
            'codestado' => Yii::t('app', 'Codestado'),
            'textocomercial' => Yii::t('app', 'Textocomercial'),
            'textointerno' => Yii::t('app', 'Textointerno'),
            'textotecnico' => Yii::t('app', 'Textotecnico'),
        ];
    }

    
    public function getCliente()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
     public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }
    public function getResponsable()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }
    
     public function getProceso()
    {
        return $this->hasOne(OpProcesos::className(), ['id' => 'proc_id']);
    }
    
     public function getActivo()
    {
        return $this->hasOne(\frontend\modules\mat\models\MatActivos::className(), ['codigo' => 'codactivo']);
    }
    
      public function getIngreso()
    {
        return $this->hasOne(MatDetNe::className(), ['id' => 'detgui_id']);
    }
     public function getDetalles()
    {
        return $this->hasMany(OpOsdet::className(), ['os_id' => 'id']);
           //return $this->hasMany(Examenes::className(), ['citas_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     * @return OpOsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpOsQuery(get_called_class());
    }
    
    
    /*
     * Crea un despice entregable automaticamente
     * En los casos del Tipo A y B crea el msimo equipo o 
     * componente en los casos C crea un grupo de componentes
     * En el caso D, crea una estrcutura cualquiera 
     */
    public function creaEntregable(){
        
      if($this->isTypeEstructural()){
          yii::error('isTypeEstructural',__FUNCTION__);
          $this->creaEntregableMismoComponente();
      }elseif($this->isTypeComponente()){
           yii::error('isTypeComponente',__FUNCTION__);
          $this->creaEntregableMismoComponente();
      }elseif($this->isTypeGrupoComponentes()){
           yii::error('isTypeGrupoComponentes',__FUNCTION__);
          $this->creaEntregableGrupoComponentes();
      }elseif($this->isTypeDesconocido()){
           yii::error('desconocido',__FUNCTION__);
          //NO crea nada
      }
       
    }
    
    public function validate_codes($attribute, $params){
      if($this->isTypeEstructural()){
         if(empty($this->codart))
          $this->addError('codart',yii::t('base.errors','Codigo es obligatorio en este tipo')); 
          if(empty($this->codactivo))
          $this->addError('codactivo',yii::t('base.errors','Codigo activo es obligatorio en este tipo')); 
         
       }
      if($this->isTypeComponente() || $this->isTypeGrupoComponentes()){
           if(empty($this->codart))
          $this->addError('codart',yii::t('base.errors','Codigo es obligatorio en este tipo')); 
          if(empty($this->cant))
          $this->addError('cant',yii::t('base.errors','Codigo activo es obligatorio en este tipo')); 
       } 
       
    }
    
    
    
    private function creaEntregableMismoComponente(){
        $model= OpOsdespiece::instance();
        $attributes=[
            'proc_id'=>$this->proc_id,
            'os_id'=>$this->id,            
             ];
        if($this->isTypeEstructural()){
            $attributes['descripcion']=$this->activo->descripcion;
             $attributes['serie']=$this->activo->serie;
        }
        if($this->isTypeComponente()){
            $attributes['descripcion']=$this->material->descripcion;
        }
        $model->setAttributes([$attributes]);
        if(!$model->save())
             yii::error($model->getErrors(),__FUNCTION__);
    }
    
    /*
     * Crea componentes hijos de acuerdo a la cantidad especificada
     * asigna a cada uno una descriocion #1 , #2 secuencialmente
     */
    private function creaEntregableGrupoComponentes(){
        //yii::error('Ingresando a  ',__FUNCTION__);
        $model=null;
        $attributes=[
            'proc_id'=>$this->proc_id,
            'os_id'=>$this->id,            
             ];
        $descripcion=$this->material->descripcion;
        //yii::error('Ahora el for  ',__FUNCTION__);
        //yii::error('la cantidad   '.$this->cant,__FUNCTION__);
       for ($i=1;$i<=$this->cant;$i++) {
           //yii::error('El  i  '.$i,__FUNCTION__);
           $model=new OpOsdespiece;
           $attributes['descripcion']=trim($descripcion).' # '.$i;
             //$attributes['serie']=$this->activo->serie;
           //yii::error('attibutss',__FUNCTION__);
           //yii::error($attributes,__FUNCTION__);
            $model->setAttributes($attributes);
           // yii::error('Loa atributos del modelo',__FUNCTION__);
             //yii::error( $model->attributes,__FUNCTION__);
            if(!$model->save())
             yii::error($model->getErrors(),__FUNCTION__);
       }
    }
    
    
    /*
     * Crea un registro actividad hijo automáticamente 
     */
    public function creaHijo(){
        $model=OpOsdet::instance();
        $model->setAttributes([
            'proc_id'=>$this->proc_id,
            'os_id'=>$this->id,
            'finicio'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'),'date',true),
            'termino'=>self::SwichtFormatDate(self::CarbonNow()->format('Y-m-d'),'date',true),
             'descripcion'=>$this->descripcion,
            'emplazamiento'=>self::LUGAR_TALLER,
            'interna'=>true,
            
                ]);
        $model->save();
        //print_r($model->getErrors());die();
    }
    
     public function beforeSave($insert) {
       // yii::error('funcion beforeSave  '.date('Y-m-d H:i:s'));
        if ($insert) { 
           if(is_null($this->codpro))$this->codpro= VwSociedades::codpro();
           $this->item='1'.str_pad($this->proceso->getOrdenes()->count()+1,2,'0',STR_PAD_LEFT);
            
           $this->numero =$this->proceso->numero.'-'.$this->item;  
          // var_dump( $this->numero);die();
           
        }       
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes) {
        if($insert){      
            $this->refresh();
            $this->creaHijo();
            $this->creaEntregable();
            
            
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function  numerodoc(){
        return $this->numero;
    }
    public function tipo(){
        return 'S';
    }
    public function codcen(){
       return $this->codcen;
    }
    
     public function monto(){
         return 23.4;
     }
 
    public static function buscarporNumero($numero){
        return self::findOne(['numero'=>$numero]);
    } 
    
    public function hasIngreso(){
        return $this->detgui_id>0;
    }
    
   public function isTypeEstructural(){
       return ($this->tipoes==self::TYPE_ESTRUCTURAL_EQUIPO);
   }
   public function isTypeComponente(){
       return ($this->tipoes==self::TYPE_COMPONENTE_ROTATIVO);
   } 
  public function isTypeGrupoComponentes(){
       return ($this->tipoes==self::TYPE_COMPONENTES_VARIOS);
       
   } 
  public function isTypeDesconocido(){
       return ($this->tipoes== self::TYPE_ESTRUCTURA_DESCONOCIDA);
       
   } 
   
  public function isEntregable(){
      return !$this->isTypeDesconocido();
  }

}
