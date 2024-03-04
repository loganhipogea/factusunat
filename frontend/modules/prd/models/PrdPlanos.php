<?php

namespace frontend\modules\prd\models;
use frontend\modules\mat\models\MatDespiece;
use common\behaviors\FileBehavior;
use frontend\modules\prd\models\PrdPlanosRevisiones;
use Yii;

/**
 * This is the model class for table "{{%prd_planos}}".
 *
 * @property int $id
 * @property string|null $codart No necesarimente es obligatorio
 * @property string|null $descriplano descricion del plano
 * @property string|null $comentario
 * @property int|null $activo_id
 * @property string|null $rol Rol de acceso a este plano
 * @property string|null $fecha Fecha de creacion del plano
 * @property string|null $revision numero de revision actual 001 002 003
 * @property int|null $matdespiece_id
 * @property string|null $codigo CODIGO RESFER DEL PLANO
 * @property string|null $current_status CODIGO del STATUS
 * @property string|null $status status  cre\ap\anu
 */
class PrdPlanos extends \common\models\base\modelBase
{
    
    
    public CONST ST_CREADO='CRE';
    public CONST ST_APROBADO='APR';
    public CONST ST_ANULADO='ANX';
    public CONST ST_REVISION='REV';
    
    public CONST REV_INICIAL='00';
    public static function mapEstados(){
      return [ 
          self::ST_CREADO=>Yii::t('base.names','CREADO'),
        self::ST_ANULADO=>yii::t('base.names','ANULADO'),
         self::ST_REVISION=>yii::t('base.names','EN REVISION'),
        self::ST_APROBADO=>yii::t('base.names','APROBADO'),
        
       ];  
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%prd_planos}}';
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
    public $dateorTimeFields = [
        'fecha' => self::_FDATE,  
         
    ];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comentario'], 'string'],
            [['activo_id', 'matdespiece_id'], 'integer'],
             [['fecha'], 'safe'],
            [['codart'], 'string', 'max' => 14],
            [['descriplano'], 'string', 'max' => 60],
            [['rol'], 'string', 'max' => 80],
           // [['fecha'], 'string', 'max' => 10],
            [['revision'], 'string', 'max' => 3],
            [['codigo'], 'string', 'max' => 30],
            [['current_status'], 'string', 'max' => 4],
            [['status'], 'string', 'max' => 40],
        ];
    }
    public function getMatDespiece()
    {
        return $this->hasOne(MatDespiece::className(), ['id' => 'matdespiece_id']);
    }
    
    public function getMaterial()
    {
        return $this->hasOne(\common\models\masters\Maestrocompo::className(), ['codart' => 'codart']);
    }
    
    
    public function getRevisiones()
    {
        return $this->hasMany(PrdPlanosRevisiones::className(), ['plano_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codart' => Yii::t('app', 'Codart'),
            'descriplano' => Yii::t('app', 'Descriplano'),
            'comentario' => Yii::t('app', 'Comentario'),
            'activo_id' => Yii::t('app', 'Activo ID'),
            'rol' => Yii::t('app', 'Rol'),
            'fecha' => Yii::t('app', 'Fecha'),
            'revision' => Yii::t('app', 'Revision'),
            'matdespiece_id' => Yii::t('app', 'Matdespiece ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'current_status' => Yii::t('app', 'Current Status'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PrdPlanosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PrdPlanosQuery(get_called_class());
    }
    
    
    public function beforeSave($insert) {
        if($insert){
            $this->current_status=self::workFlows()['inicial'];
            $this->revision=self::REV_INICIAL;
            
        }else{
            if($this->hasChanged('current_status')){
                $this->status.='\\'.$this->current_status;
                
            }
        }
        
        return parent::beforeSave($insert);
    }
    
 public function afterSave($insert, $changedAttributes) {
     
     if($insert){
         $this->refresh();
         $this->creaRevision(self::REV_INICIAL);
     }
     return parent::afterSave($insert, $changedAttributes);
 }   
    /*
  * Flujo de trabajo para las piezas
  * PT
  */
 public static function workFlows(){
    return [
        
        
                'inicial'=>self::ST_CREADO,
                 self::ST_CREADO=>[   self::ST_ANULADO=>self::mapEstados()[self::ST_ANULADO],self::ST_REVISION=>self::mapEstados()[self::ST_REVISION]  ],
                 self::ST_ANULADO=>[],
        
        self::ST_REVISION=>[  self::ST_ANULADO=>self::mapEstados()[self::ST_ANULADO] ,self::ST_APROBADO=>self::mapEstados()[self::ST_APROBADO] ],
        
                self::ST_APROBADO=>[  self::ST_REVISION=>self::mapEstados()[self::ST_REVISION]  ],
                 
      
       ];
 }
 
 /*private function lastStatus(){
     $partes=explode('\\', $this->status);
     if(count($partes)>0){
         return $partes[count($partes)-1];
     }else{
         return $this->status;
     }
 }*/
 public function possibleStatus(){
     return self::workFlows()[$this->current_status];
 }
 
 public function creaRevision($rev){
     PrdPlanosRevisiones::firstOrCreateStatic([
         'plano_id'=>$this->id,
         'cambio'=>'Escriba el cambio aquí... ',
         'fecha'=>$this->currentDateInFormat(),
         'rev'=>$rev
     ], null,['plano_id'=>$this->id,'rev'=>$rev]);
 }
 
 public function isAprobado(){
     return $this->current_status==self::ST_APROBADO;
 }
 
 public function maxRevision(){
     return $this->getRevisiones()->orderBy(['rev'=>SORT_DESC])->one();
 }
 
 public function setAprobado(){
     $this->current_status=self::ST_APROBADO;
     return $this;
 }
 
 public function statusPosiblesForAprobe(){
     return [[self::ST_APROBADO],[self::ST_ANULADO,self::ST_APROBADO]];
 }
 
 public function hasRevisiones(){
    return  $this->getRevisiones()->count() >0;
 }
}
