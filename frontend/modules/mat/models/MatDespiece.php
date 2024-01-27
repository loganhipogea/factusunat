<?php

namespace frontend\modules\mat\models;
use common\models\masters\Maestrocompo;
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
            [['codart','activo_id'], 'required'],
            [['cant'], 'number'],
            [['parent_id', 'activo_id', 'nivel', 'prioridad'], 'integer'],
            [['secuencia', 'of', 'esemplazamiento'], 'safe'],
            [['ruta', 'ruta2'], 'string'],
            [['codart'], 'string', 'max' => 14],
            [['clave'], 'string', 'max' => 20],
            [['codart'], 'unique'],
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
    public function arrayForTree(){
        return [
            'key'=>$this->id ,
             'icon'=>'fa fa-dropbox',
            'title'=>$this->id.'  -   '.$this->material->descripcion , 
            'children'=>[],
        ];
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
    

}
