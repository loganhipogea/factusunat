<?php
namespace common\widgets\buttonsubmitwidget;
use yii\base\Widget;
use yii;
use yii\web\View;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
class buttonSubmitWidget extends Widget
{
   const OP_PRIMERA=1;
   const OP_SEGUNDA=2;
    const OP_TERCERA=2;
    public $id;
   public $idGrilla=null; //Id del sectro Pjax par arefrescar luego de la accion 
    public $idForm=null; //NOMDE O ID DEL FOMRULARIO A hahacer submit
   public $idModal=null;    //id de la ventana MOdal
   public $url=null; //Direccion a la cual se redirecciona 
   public $title='Guardar';
   public $scriptAfterSuccess='';
   
    
    public function init()
    {
        
        if($this->url===NULL)
        throw new InvalidConfigException('The "url" property is Null.');
       if($this->idForm===NULL)
        throw new InvalidConfigException('The "idForm" property is Null.');
       
        if($this->idGrilla===NULL)
        throw new InvalidConfigException('The "idGrilla" property is Null.');
        if($this->idModal===NULL)
        throw new InvalidConfigException('The "idModal" property is Null or not Valid');
  
        parent::init();
    }

    public function run()
    {
       
        echo Html::button($this->title,['onclick'=>"psico_saves_widget()", 'class' => 'btn btn-success']);
        $this->makeJs();
        
        
    }
  
     
  private function makeJs(){
       if(substr(trim($this->idGrilla),0,1)=='['){
           $idGrilla= \yii\helpers\Json::decode($this->idGrilla); 
       }else{
           $idGrilla= $this->idGrilla;
       }
       
       $cadAux='';
       $cadAux2='';
    if(is_array($idGrilla)){
       if(count($idGrilla)==1){
           $cadAux.="$.pjax.reload('#".$idGrilla[0]."');";
       }else{
           foreach($idGrilla as $index=>$grilla){
          //$cadAux.="$.pjax.reload('#".$grilla."');";
         
          $cadAux.="$.pjax.reload({container:'#".$grilla."',async:false,timeout:6000});";
           }
       }
       
    }else{
       $cadAux.="$.pjax.reload('#".$idGrilla."');"; 
      // $cadAux2.="$.pjax.reload({container:'#".$this->idGrilla."',timeout:6000});";
    }
    
    
   $cadenaJs="function psico_saves_widget(){
        var \$formulario=$('#".$this->idForm."');       
        $.ajax({
            url:'".$this->url."',
            type: 'post',
            data:\$formulario.serialize(),
            success: function(data){
          
               if(data.success=='1') {
                  hacer_click();
                       
                   if(data.type==1) {
                       $('#".$this->idModal."').modal('hide');                        
                        ".$cadAux."  
                    }else{
                          $('#".$this->idModal."').modal('hide');
                                ".$cadAux."  
                     }
                     
               }
               if(data.success=='3'){
                      var msg=data.msg;
                      var n = Noty('id');
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ msg);
                        $.noty.setType(n.options.id, 'error'); 
                    }
               if(data.success=='2') {
                   var msg=data.msg;
                   if(msg){
                       $.each(msg,function(key,val){
                           var div=$('.field-'+key);
                           div.addClass(' has-error');
                           div.find('.help-block').html(val);
                       });
                   }
               }
            }
              });
        
        
    }";
   $this->getView()->registerJs($cadenaJs, \yii\web\View::POS_HEAD);
   
   $cadenaJs2="function hacer_click(){
       // psico_saves_widget();
        afterSuccess();
           }";
   $this->getView()->registerJs($cadenaJs2, \yii\web\View::POS_HEAD);
   
   $cadenaJs3="function afterSuccess(){
        ".$this->scriptAfterSuccess."  
           }";
   $this->getView()->registerJs($cadenaJs3, \yii\web\View::POS_HEAD);
   
   
   
  } 
  
}

?>