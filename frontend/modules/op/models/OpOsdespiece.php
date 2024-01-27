<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "op_osdespiece".
 *
 * @property int $id
 * @property int|null $os_id
 * @property int|null $parent_id
 * @property string|null $ruta
 * @property string|null $ruta2
 * @property string $abreviatura
 * @property string|null $clave
 * @property string|null $final
 * @property int|null $nivel
 * @property int|null $prioridad
 */
class OpOsdespiece extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'op_osdespiece';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['os_id', 'parent_id', 'nivel', 'prioridad'], 'integer'],
            [['ruta', 'ruta2'], 'string'],
            [['abreviatura'], 'required'],
            [['abreviatura'], 'string', 'max' => 14],
            [['clave'], 'string', 'max' => 20],
            [['final'], 'string', 'max' => 1],
            [['abreviatura'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'ruta' => Yii::t('app', 'Ruta'),
            'ruta2' => Yii::t('app', 'Ruta2'),
            'abreviatura' => Yii::t('app', 'Abreviatura'),
            'clave' => Yii::t('app', 'Clave'),
            'final' => Yii::t('app', 'Final'),
            'nivel' => Yii::t('app', 'Nivel'),
            'prioridad' => Yii::t('app', 'Prioridad'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return OpOsdespieceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpOsdespieceQuery(get_called_class());
    }
    
      /*
     *  ActiveQuery hijos
     */
    public function childsQuery(){
        return $this->find()->andWhere(['parent_id'=>$this->id]);
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
       $hijos=$this->childsArrayRows();
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
            'title'=>$this->abreviatura.'  -   '.$this->descripcion , 
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
            //yii::error(' '.$this->id.'  -  '.$this->codart.' NO  tiene hijos',__FUNCTION__); 
           return $this->arrayForTree();
       }
            
    }
   
    
    
}
