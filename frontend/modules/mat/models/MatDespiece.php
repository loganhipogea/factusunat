<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
use common\behaviors\FileBehavior;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "mat_despiece".
 *
 * @property int $id
 * @property string $codart
 * @property float|null $cant
 * @property string|null $clave
 * @property int|null $parent_id
 * @property int|null $activo_id
 * @property int|null $nivel
 * @property string|null $ruta
 * @property string|null $ruta2
 * @property int|null $prioridad
 */
class MatDespiece extends \common\models\base\modelBase
{
    public CONST ST_CREADO='CRE';
    public CONST ST_ANULADO='AN';
    public CONST ST_DISENO='DIS';
    public CONST ST_PLANOAPROBADO='PAP';
    public CONST ST_FABRICACION='FAB';
    public CONST ST_TRANSPORTE='TRA';
    public CONST ST_RECHAZO='REX';
    public CONST ST_RECEP='RCP';
     CONST ST_ENSAMBLE='ENS';

    public static function mapEstados(){
      return [ 
          self::ST_CREADO=>Yii::t('base.names','CREADO'),
        self::ST_ANULADO=>yii::t('base.names','ANULADO'),
         self::ST_DISENO=>yii::t('base.names','DISENO'),
        self::ST_PLANOAPROBADO=>yii::t('base.names','PLANOS APROBADOS'),
        self::ST_FABRICACION=>yii::t('base.names','FABRICACION'),
        self::ST_TRANSPORTE=>yii::t('base.names','TRANSPORTE'),
        self::ST_RECHAZO=>yii::t('base.names','RECHAZADO'),
           self::ST_RECEP=>yii::t('base.names','RECEPCIONADO'),
        self::ST_ENSAMBLE=>yii::t('base.names','ENSAMBLE'),
        
       ];  
    }
      
   
    
    private $_id=-1; 
    private $_flujos=[];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mat_despiece';
    }
    public $booleanFields=['esemplazamiento'];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['codart','activo_id'], 'required'],
            [['cant'], 'number'],
            [['parent_id', 'activo_id', 'nivel', 'prioridad'], 'integer'],
            [['secuencia', 'of', 'esemplazamiento','modelobase_id','activo_id','status','current_status'], 'safe'],
            [['ruta', 'ruta2'], 'string'],
            [['codart'], 'string', 'max' => 14],
            [['clave'], 'string', 'max' => 20],
            //[['codart'], 'unique'],
              [['codart'], 'exist', 
                  'skipOnError' => false, 
                  'skipOnEmpty'=> true, 
                  'targetClass' => \common\models\masters\Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
          
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codart' => Yii::t('app', 'Codart'),
            'cant' => Yii::t('app', 'Cant'),
            'clave' => Yii::t('app', 'Clave'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'activo_id' => Yii::t('app', 'Activo ID'),
            'nivel' => Yii::t('app', 'Nivel'),
            'ruta' => Yii::t('app', 'Ruta'),
            'ruta2' => Yii::t('app', 'Ruta2'),
            'prioridad' => Yii::t('app', 'Prioridad'),
        ];
    }
     public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }
     public function getMaterialSolicitado()
    {
        return $this->hasOne(\common\models\masters\MaestrocompoSol::className(), ['codart' => 'codart']);
    }
    
    
    public function getModeloBase()
    {
        return $this->hasOne(\common\models\masters\Modelosbase::className(), ['id' => 'modelobase_id']);
    }
    
    
    public function clave(){
      return '_'.$this->id;
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->resolveStatus();
            $this->creado=date('Y-m-d h:i:s');
            $this->username=h::userName();
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
            $id=$this->id;
            self::updateAll(['clave'=>'_'.$id], ['id'=>$id]);
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /*
     *  ActiveQuery hijos
     */
    public function childsQuery(){
        return $this->find()->andWhere(['parent_id'=>$this->id])->alias('t');
    }
    
     /*
     *  Registros hijos en modelos
     */
    public function childs(){
       return $this->childsQuery()->all();
    }
    
    /*Si
     * tiene registros hijos
     */
    public function hasChilds(){
        return $this->childsQuery()->count()>0;
    }
  
    
     /*
     *  Registros hijos en arrays 
     */
    public function childsArrayRows(){
       return $this->childsQuery()->asArray()->all();
    }
    
    
    
    
    /*
     * Hijos en array formato Tree view
     */
    public function childsTree(){
       $hijos=$this->childsQuery()->select(['t.*','b.descripcion'])->
    innerJoin(Maestrocompo::tableName().' b')
               ->onCondition("t.codart=b.codart")->asArray()->all();
       yii::error($this->childsQuery()->select(['t.*','b.descripcion'])->
    innerJoin(Maestrocompo::tableName().' b')
               ->onCondition("t.codart=b.codart")->asArray()->createCommand()->rawSql,__FUNCTION__);
       $ramas_hijas=[];
       foreach($hijos as $hijo){
         $ramas_hijas[]=[              
            'icon'=>'fa fa-dropbox',
            'key'=>$hijo['clave'],
            'title'=>$hijo['descripcion'],        
           ];  
       }
       return $ramas_hijas;
    }
    /*
     * Devuelve un array de la forma 
     * 
     *   [ 'key'=>23 , 'title'=>'Mi nodo' , 'children'=>$this->cjildsTree() ]
     * 
     *   El array children se obtiene de la funcion childsTree()
     */
    public function arrayForTree($icon=NULL,$title=NULL){
       $key=$this->clave;
       $icon=(is_null($icon))?'fa fa-dropbox':$icon;
       $title=((is_null($title))?$this->codart.'-'.$this->material->descripcion:$title).$this->buildButtons(MatActivos::instance());        
        return self::arrayForTreeBase($key, $icon,$title);
    }
    
    
    public static function arrayForTreeBase($key, $icon=null,$title){
        return [
            'key'=>$key ,
             'icon'=>$icon,
            'title'=>$title , 
            'children'=>[],
        ];
    }
    
    /*
     * Definamos un array para construir un nodo
     * Este array debe de tener las claves basicas
     * 
     *    key=>[],
     *    icon=>[],
     *    title=>[],
     *    urls=>[], Array de Urls 
     */
    
    public function array_for_node(){
        
    }
    
    
    private function buildUrls(){
        
    }
    
    
    
    /*
     * Va buscando las ramas hijas 
     * recursivamente
     */
    
    public function childsTreeRecursive($icon=null,$title=null){
        $array_hijos=[];
        //yii::error('EJECUTANDO EN  '.$this->id.'  -  '.$this->codart,__FUNCTION__);
       if($this->hasChilds()){
          // yii::error(' '.$this->id.'  -  '.$this->codart.' SI  tiene hijos',__FUNCTION__); 
          foreach($this->childs() as $child){  
                     $arr=$child->arrayForTree($icon,$title);
                     $arr['children']=$child->childsTreeRecursive();
                $array_hijos[]=$arr;
            } 
          
           return $array_hijos;
       }else{
            yii::error(' '.$this->id.'  -  '.$this->codart.' NO  tiene hijos',__FUNCTION__); 
           return $this->arrayForTree($icon,$title);
       }
            
    }
    

    /*
    * Funcion que genera los Hrmls de los
    * botones de los enlaces
    * ursl= [
    *   'icon'=>Url,
    *   'icon2'=>url2,
    * 
    * ]
    * 
    */
   public function buildButtons($modelo,$id=null){
       $id=(is_null($id))?$this->id:$id;
       
       
       $urls=$modelo->urlsTreeViewButtons();
       $cad="  |";
       foreach($urls as $clave=>$button){
           if(array_key_exists('rel', $button['attrEnlace'])){
               $button['attrEnlace']['rel']=Url::to($button['attrEnlace']['rel']);
           }
           if(is_array($button['url'])){
               $button['url']['id']=$id;
               
               $cad.=Html::a('<i style=""><span class="'.$button['icon'].'"></i>',Url::to($button['url']),$button['attrEnlace'])."|";
           }else{
                $cad.=Html::a('<i style=""><span class="'.$button['icon'].'"></i>',$button['url'],$button['attrEnlace'])."|";
        
           }
       }
     return $cad;
   } 
   
   
  
   
   public function buildTitle(){
       $cad=" ";
       foreach($this->titleTreeView($this) as $clave=>$valor){
          $cad.="<span>".$valor['valor']."</span>";
       }
       
   }
    
   public function titleTreeView(){
    return [
        "codart"=>[
                    "valor"=>$this->codart,
                      "style"=>"font-weight:800;",
                    ],
       "descripcion"=>[
              "valor"=>$this->material->descripcion,
                    ], 
       "cant"=>[
           "valor"=>$this->cant,
             "style"=>"font-weight:800;",
                    ], 
    ];
 } 
 
 
 public function obtieneId(){
   if($this->_id <0){
       if($this->isNewRecord){
        $model=self::find()->select()->orderBy(['id'=>SORT_DESC])->one();
        $this->_id= (is_null($model))?null:$model->id;
    }else{
        $this->_id=$this->id;
    }
   }
   return $this->_id; 
 }
 
 
 
 /*
  * Flujo de trabajo para las piezas
  * PT
  */
 public static function workFlows(){
    return [
        
        'activo'=>[
                'inicial'=>self::ST_CREADO,
                 self::ST_CREADO=>[   self::ST_ANULADO=>self::mapEstados()[self::ST_ANULADO],self::ST_DISENO=>self::mapEstados()[self::ST_DISENO]  ],
                 self::ST_ANULADO=>[],
                    self::ST_DISENO=>[  self::ST_ANULADO=>self::mapEstados()[self::ST_ANULADO] ,self::ST_PLANOAPROBADO=>self::mapEstados()[self::ST_PLANOAPROBADO] ],
                    self::ST_PLANOAPROBADO=>[  self::ST_FABRICACION=>self::mapEstados()[self::ST_FABRICACION] ,self::ST_RECHAZO=>self::mapEstados()[self::ST_RECHAZO] ],
                  self::ST_FABRICACION=>[  self::ST_TRANSPORTE=>self::mapEstados()[self::ST_TRANSPORTE] ],
                self::ST_TRANSPORTE=>[  self::ST_RECEP=>self::mapEstados()[self::ST_RECEP] ],
               self::ST_RECEP=>[  self::ST_RECHAZO=>self::mapEstados()[self::ST_RECHAZO],self::ST_ENSAMBLE=>self::mapEstados()[self::ST_ENSAMBLE]  ],
               self::ST_ENSAMBLE=>[  self::ST_RECHAZO=>self::mapEstados()[self::ST_RECHAZO] ],
               self::ST_RECHAZO=>[  self::ST_PLANOAPROBADO=>self::mapEstados()[self::ST_PLANOAPROBADO],self::ST_FABRICACION=>self::mapEstados()[self::ST_FABRICACION],self::ST_ENSAMBLE=>self::mapEstados()[self::ST_ENSAMBLE]  ],
            ] ,
        
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
     return self::workFlows()['activo'][$this->current_status]+[$this->current_status=>self::mapEstados()[$this->current_status]];
 }
 /*
  * Califica el estado según 
  * El material
  * Si el material es ieza nueva 
  * comeinza de cero
  * Si ya ha renido planos en otro equipo
  * Asigna el estado que tiene los planos listos 
  */
 public function resolveStatus(){
     if($this->isNewRecord ){
        if($this->material->hasPlanosAprobados()){
                        $this->current_status=$this->workFlows()['activo']['inicial'];
        }else{
            $this->current_status=self::ST_PLANOAPROBADO;
        }
     }
 }
 
}
 

