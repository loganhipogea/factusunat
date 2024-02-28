<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\ComboHelper;
use yii\widgets\ActiveForm;
use common\behaviors\FileBehavior;
use common\widgets\selectwidget\selectWidget;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Maestrocompo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maestrocompo-form">

    <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
    
    <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
         
          if($model->isNewRecord){
            $url=\yii\helpers\Url::to(['/masters/modelos-base/modal-crea-nodo','id'=>$id]);   
          }else{
             $url=\yii\helpers\Url::to(['/masters/modelos-base/modal-edita-nodo','id'=>$id]);  
          }
          $isNew=($model->isNewRecord)?'1':'0';
          $isRoot=($id<0)?'1':'0';
          //var_dump($isRoot); die();
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      'scriptAfterSuccess'=>" 
                
                          var_codigo=$('#matdespiece-codart').val();
         var is_new='".$isNew."';
         var is_root='".$isRoot."';    
         var promesa1= $.ajax({
            url : '".Url::to(['/masters/modelos-base/ajax-obtiene-id-despiece'])."',
          type : 'GET', 
          data : {}, 
          dataType: 'json', 
          success : function(json) {
                            idObtenido=json['success']['id'];
                            codigo=json['success']['codart']; 
                            descripcion=json['success']['descripcion']; 
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        }).then(function(){ 
        
               console.log('ingresando');
                var_url_add='".Url::to(['/masters/modelos-base/modal-crea-nodo'])."';
                var_url_add+='?id='+idObtenido+'&gridName=".$gridName."&idModal=".$idModal."' ;
            console.log('PASAMDO');
                        var tree = $('#tree').fancytree('getTree');
                               console.log('SEGUIMOS');
    
                        var key_padre=" .$id. ";
                        var node_agregar={
                               icon:'fa fa-cube',
                               title:'<i style=\"color:orange;\"><span class=\"fa fa-circle\"></i><span style=\"font-weight:900;\">'+codigo+'</span>-'+descripcion+'<a  href=\"'+var_url_add+'\"  class=\"botonAbre\"><i style=\"color:orange;\"><span class=\"fa fa-plus\"></i></a>',
                               key:'_'+idObtenido,
                              // lazy:true,
                                //folder: true
                                };
                          console.log('YA  VEMOS EL NODO');
                          console.log(node_agregar);
                            
                  if(is_root=='1'){
                   console.log('es root ');
                      var node = tree.getFirstChild();
                        node.setSelected(true); 
                        console.log(node);
                  }else{
                  console.log('NO es root ');
                       var node = tree.getNodeByKey('_'+".$id.");
                        console.log(node);
                  }
                           

                   if(is_new=='1'){
                        console.log('es NUEVO ');
                        console.log(node);
                               if(key_padre >0){
                                  node.addNode(node_agregar); 
                               } else{
                                node.parent.addNode(node_agregar); 
                                }
                   }else{
                           if(node.isExpanded()){
                               //var node_hijo = tree.getNodeByKey('_'+". $model->id ."); 
                              
                               node_hijo.setTitle('<span style=\"font-weight:900;\">'+resulta1['codart']+'</span>-'+resulta1['descripcion']+'<a  href=\"/frontend/web/masters/materials/modal-edita-material-sol?id='+var_codigo+'&gridName=grilla-arbol&idModal=buscarvalor\" class=\"botonAbre\"><i style=\"color:orange;\"><span class=\"fa fa-pencil\"></i></a>');
                              
                              // node_hijo.setSelected(true);
                            }else{
                              node.setExpanded(true); 

                            }
                     
                   }
                   
                });
                        



                                
                            "
                      ]
                  )?>
            </div>
        </div> 
    </div>  
    
    
    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codart',
         'ordenCampo'=>2,
         'addCampos'=>[2,],
        ]);  ?>

 </div> 
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'cant')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>
    </div>

 <!--This element id should be passed on to options-->

    <?php ActiveForm::end(); ?>
</div>
