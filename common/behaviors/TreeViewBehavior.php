<?php

namespace common\behaviors;
use yii;
use yii\helpers\Html;
use yii\helpers\Url;
/*
 * Esta clase se usa para 
 * modelos que adopten el tree view 
 * 
 * 
 */

class TreeViewBehavior extends \yii\base\Behavior {
  
  private $_node=[];  
    
    /*
     * Devuelve un nodo en forma de array 
     * Con los campos id y descripcion
     */
    public function node($title){
       if(count($this->_node)==0){
           
          $this->_node= [
             'icon'=>'fa fa-cube',
            'key'=>'_'.$this->owner->id,
             'title'=>$title,
            'children'=>[],
            ];
       }
      return $this->_node;  
    }
 /*
  * Inyecta un url hipervinciulo al title
  */
   public function addLinkNode($url,$options){
       if(empty($options))
       $options=['class'=>'botonAbre'];
      $this->_node['title']=$this->_node['title'].Html::a('<span class="fa fa-plus"></span>',$url,$options);
   }
   
   /*
    * Obtiene  el query para childs
    */
   private function childsModelsQuery(){
       return $this->owner->find()->andWhere(['parent_id'=>$this->owner->id]);
   }
   
   /*
    * Obtiene  los childs, en formato 
    * models active record
    */
   private function childsModels(){
       return $this->childsModelsQuery()->all();
   } 
   
   /*
    * Obtiene  los childs, en formato 
    * Array
    */
   private function childsArray(){
       return $this->childsModelsQuery()->asArray()->all();
   }
  
   
}
