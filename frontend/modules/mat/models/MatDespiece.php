<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
use common\behaviors\FileBehavior;
use yii\helpers\Html;
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
    
    
    private $_id=-1; 
    
    
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
            [['secuencia', 'of', 'esemplazamiento','modelobase_id'], 'safe'],
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
    public function getModeloBase()
    {
        return $this->hasOne(\common\models\masters\Modelosbase::className(), ['id' => 'modelobase_id']);
    }
    
    
    public function clave(){
      return '_'.$this->id;
    }
    
    public function beforeSave($insert) {
        
       
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
    public function arrayForTree($key=NULL,$icon=NULL,$title=NULL){
       $key=(is_null($key))?$this->id.'':$key;
       $icon=(is_null($icon))?'fa fa-dropbox':$icon;
       $title=(is_null($title))?$this->codart.'-'.$this->material->descripcion:$title;        
        return self::arrayForTreeBase($key, $icon,$title);
    }
    
    
    public static function arrayForTreeBase($key=null,$icon=null,$title){
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
    
    public function childsTreeRecursive(){
        $array_hijos=[];
        //yii::error('EJECUTANDO EN  '.$this->id.'  -  '.$this->codart,__FUNCTION__);
       if($this->hasChilds()){
          // yii::error(' '.$this->id.'  -  '.$this->codart.' SI  tiene hijos',__FUNCTION__); 
          foreach($this->childs() as $child){  
                     $arr=$child->arrayForTree();
                     $arr['children']=$child->childsTreeRecursive();
                $array_hijos[]=$arr;
            } 
          
           return $array_hijos;
       }else{
            yii::error(' '.$this->id.'  -  '.$this->codart.' NO  tiene hijos',__FUNCTION__); 
           return $this->arrayForTree();
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
   public function buildButtons($modelo){
       
       $urls=$modelo->urlsTreeViewButtons($this->id);
       $cad="  |";
       foreach($urls as $icon=>$url){
           $cad.=Html::a('<i style=""><span class="'.$icon.'"></i>',$url['url'],$url['optionsEnlace'])."|";
       }
     return $cad;
   } 
   
   
   public function buttonAdd($icon,$url,$optionsEnlace){
       $cad="  |";
           $cad.=Html::a('<i style=""><span class="'.$icon.'"></i>',$url,$optionsEnlace)."|";
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
 
}
