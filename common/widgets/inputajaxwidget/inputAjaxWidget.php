<?php
namespace common\widgets\inputajaxwidget;
//use common\models\base\modelBase;
use yii\base\Widget;
use yii\web\View;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;
use yii;
use yii\base\InvalidConfigException;
class inputAjaxWidget extends \yii\base\Widget
{
    public $id;
    public $id_input=null;
    public $tipo='GET';
    public $ruta='';
    public $dataType='json';
    public $posicion=\yii\web\View::POS_END;
    public $isDivReceptor=false; //Si el campo a llenar es un div(true) o un imput
    //public $model=null;
    public $data=['uno'=>1];
     public $otherContainers=[];
    PUBLIC $isHtml=false;
    public $evento='change';    
    public $idGrilla=null; //Ids de los contendeores pjax a refrescar
    public function init()
    {
       
        parent::init();
         //$this->registerTranslations();
    }

    public function run()
    {  // Register AssetBundle
        inputAjaxWidgetAsset::register($this->getView());
         if($this->isHtml){
             $this->makeJsHtml();
         }else{
              $this->makeJs();
         }
       
    }
    
    
    
 private function makeJsHtml(){
     $operador=($this->isDivReceptor)?'html':'val'; 
   $this->getView()->registerJs("$(document).ready(function() {
    $('#".$this->id_input."').one('".$this->evento."',function(){
    var_input=$('#".$this->id_input."').val(); 
    var_datos=".Json::encode($this->data).";
    var_datos['valorInput']=var_input;
    console.log(var_datos);    
  $.ajax({ 
   url:'".$this->ruta."',
   type:'".$this->tipo."',
   dataType:'html',  
   data:var_datos,
   error:function(xhr, status, error){ 
                            var n = Noty('id');                      
                             $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ xhr.responseText);
                              $.noty.setType(n.options.id, 'error');         
                                }, 
success: function (data) {


           $('#".$this->idGrilla."').".$operador."(data);
    }
       }); //ajax 
        } //on change
    );//on change
     });",$this->posicion);
 }
 
  private function makeJs(){
     $cadUx="";
    if(count($this->otherContainers)>0){
            foreach($this->otherContainers as $container){
              $cadUx.="  $.pjax.reload({container: '#".$container."', async: false});  ";   
            }
             
         }else{
           $cadUx="";  
         }
    $cadena="$(document).ready(function() {
    $('#".$this->id_input."').one('".$this->evento."',function(){
      console.log('DEPURANDO');
      console.log(".Json::encode($this->data).");
  $.ajax({ 
   url:'".$this->ruta."',
   type:'".$this->tipo."',
   dataType:'".$this->dataType."',
   data:".Json::encode($this->data).",    
  error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                },  
            success: function(json) {  
                  
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                      
                   $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                    
                                $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-ok-sign\'></span>' + json['success']);
                             $.noty.setType(n.options.id, 'success');
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-info-sign\'></span>' +json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                            
                              
                              } 
                     $.pjax.reload({container: '#".$this->idGrilla."', async: false});
                          ".$cadUx." 
           }
       }); //ajax 
        })
    })";
    
    //$cadena2="alert('hola compadre);";
   $this->getView()->registerJs($cadena,$this->posicion);
  }  
  
  
 
 
}
?>