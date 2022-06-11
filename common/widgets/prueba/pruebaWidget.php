<?php
namespace common\widgets\prueba;
use common\models\base\modelBase;
use yii\base\Widget;
use yii\web\View;
//use yii\widgets\InputWidget
use yii\helpers\Url;
use yii\base\InvalidConfigException;
class pruebaWidget extends \yii\widgets\InputWidget
{
    public $id;
    //public $attribute='';
     //public $model;//EL modelo
    public $form; //El active FOrm 
    ///public $value;
    //public $options;
     //public $id=null;
    public $controllerName='finder';
    public $actionName='searchselect';
    //public $actionNameModal='busquedamodal';
    public $model;//EL modelo
    //public $form; //El active FOrm 
   // public $campo;//el nombre del campo modelo
    public $tabular=false; //Cuando se trata de renderizar en una grilla o tabala 
    public $multiple=false; //si se puede seleccionar   mas de un valor 
   // public $foreignskeys=[2,3,4];//Orden de los campos del modelo foraneo 
    //que s evan a amostrar o renderizar en el forumlario eta propida debe de especficarse al momento de usar el widget 
    private $_foreignClass; //nombe de la clase foranea
    private $_foreignField; //nombre del campo foranea
    private $_secondField=null; //el  nombde del campo oraneo a mosrtar en el comno
    //private $_varsJs=[];
    public $ordenCampo=1; //EL campo a mostrar por el combo 
    public $addCampos=[];///Campos adicionales 
    private $_modelForeign=null; //El obejto modelo foraneo
    PRIVATE $_orden=null; //para renderizar widgets en tabulares
    //public $inputOptions=[];//Array de opciones del active Field 
    public $data=[];//datos para llenar por defaulr 
    
    public function init()
    {
        
        parent::init();
        //echo get_class($this->model);die();
        if(!($this->model instanceof modelBase))
       throw new InvalidConfigException('The "model" property is not subclass from "modelBase".');
        /*if(!($this->form instanceof \yii\widgets\ActiveForm))
        throw new InvalidConfigException('The "form" property is not subclass from "ActiveForm".');
        */
        $this->_foreignClass=$this->model->obtenerForeignClass($this->attribute);
        $this->_foreignField=$this->model->obtenerForeignField($this->attribute);
    }

   public function run()
    {
         // Register AssetBundle
        pruebaWidgetAsset::register($this->getView());
        $this->makeJs();
        if($this->model->isNewRecord){
            //$valores=[];
          return  $this->render('controls',[
                'model'=>$this->model,
                'form'=>$this->form,
                'campo'=>$this->attribute,
                 'esnuevo'=>$this->model->isNewRecord,
               'valoresLista'=>$this->getValoresList(),
               'multiple'=>$this->multiple,
             // 'datos'=>$this->getDataSelectedByUser(),
              //'orden'=>$this->_orden,
              'opciones'=>$this->options,
             // 'valores'=>$valores,
               // 'idcontrolprefix'=>$this->getIdControl(),
                ]);
        }else{
            //$valores=[$model->{$campo}=>
            //$this->getModelForeign()->{$this->getSecondField()}];
             return  $this->render('controls',[
                'model'=>$this->model,
                'form'=>$this->form,
                'campo'=>$this->attribute,
                  'esnuevo'=>$this->model->isNewRecord,
                 'valoresLista'=>$this->getValoresList(),
                 'id'=>$this->id,
                 'multiple'=>$this->multiple,
                //  'datos'=>$this->getDataSelectedByUser(),
                  //'orden'=>$this->_orden,
                 'opciones'=>$this->options,
               //  'valores'=>$valores,
               //  'idcontrolprefix'=>$this->getIdControl(),
                ]);
        }
       // return $this->render('controls', ['product' => $this->model]);
    }
    
 private function makeJs(){
   $this->getView()->registerJs("$(document).ready(function() {
    $('#".$this->getIdControl()."').select2( 
    {
  
  ajax: { 
   url: '".\yii\helpers\Url::toRoute($this->controllerName.'/'.$this->actionName)."',
   type: 'post',
   dataType: 'json',
   delay: 250,
 data: function (params) {
      var query = {      
        searchTerm: params.term,
        model: '".str_replace('\\','_',get_class($this->getModelForeign()))."',
            // camposad:".\yii\helpers\Json::encode($this->getAditionalFields()).",
        firstField: '".$this->_foreignField."',
        secondField: '".$this->getSecondField()."',
        thirdField:".\yii\helpers\Json::encode($this->getAditionalFields()).",
        
      }
      // Query parameters will be ?search=[term]&type=public
      return query;
    },
   processResults: function (response) {
     return {
        results: response
     };
   },
   cache: true
  }
 }
);
     
    
});",\yii\web\View::POS_END);
                        }     
        
     private function getModelForeign(){
     if(is_null($this->_modelForeign)){
        if($this->model->isNewRecord){
               if(!empty($this->model->{$this->attribute})){
                   $modelForeign=$this->_foreignClass::find()->where([
                    $this->_foreignField=>
                    $this->model->{$this->attribute}
                                                            ])->one();
               }else{
                   $modelForeign=new $this->_foreignClass; 
               }
                
            }else{
            $modelForeign=$this->_foreignClass::find()->where([
                $this->_foreignField=>
                $this->model->{$this->attribute}
                                                            ])->one();                                                        
        }
        $this->_modelForeign=$modelForeign; unset($modelForeign);       
     }
    return  $this->_modelForeign;
 }      
   
   
   private function getShortNameModel(){
       $retazos=explode('\\',get_class($this->model));
      return $retazos[count($retazos)-1];
   }
   
   /*
    * Obtiene el nombre del control del form
    * Ejemplo:  clipro-codpro
    * Es el Id del control en el Form
    */
   private function getIdControl(){
       if(is_null($this->id))
       return strtolower($this->getShortNameModel().'-'.$this->attribute);
       return $this->id;
   }
      
    
   private function getSecondField(){
       if(is_null($this->_secondField)){
          $model=$this->getModelForeign();
          $this->_secondField=array_keys($model->attributes)[$this->ordenCampo];
        return  $this->_secondField;
       }
       return $this->_secondField;
       
   }
   
  private function getValoresList(){
       
       if($this->model->isNewRecord && $this->getModelForeign()->isNewRecord){          
           return [];       
       }else{           
       return [
           $this->getModelForeign()->{$this->_foreignField}=>
           $this->getModelForeign()->{$this->getSecondField()}
           ];
       }
   }
  
   /*
    * Obtiene el array de datos pasados por GET
    * cuando se trata de modo multiple, esto para
    * recordar al sguietne request, que valores
    * selecciono el usuario antes de enviar el form
    */
  private function getDataSelectedByUser(){
      if(\yii::$app->request->isGet && !empty(\yii::$app->request->params)){
          $params=\yii::$app->request->queryParams;
      $valorClave=$params[$this->getShortNameModel()][$this->attribute];
      if(is_array($valorClave && $this->multiple)){
          return $valorClave;
      }else{
          return [];
      }
      }else{
          return [];
      }
      
      
  }
   
  
  private function getAditionalFields(){
      $fieldsForeigns=array_keys($this->getModelForeign()->attributes);
      $campos=[];
      foreach($this->addCampos as $key=>$value){
          if(isset($fieldsForeigns[$value])){
              $campos[]=$fieldsForeigns[$value];
          }
      }       
      array_unshift($campos, $this->getSecondField());
      array_unshift($campos, $this->_foreignField);
     return $campos;
  }
  
  public function runf()
    {
          //
        return \yii\helpers\Html::activeDropDownList($this->model, $this->attribute, ['uno'=>'uno','dos'=>'dos'], $this->options);
        }
   
}
?>