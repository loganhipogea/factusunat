<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\mat\helpers\comboHelper;
use yii\widgets\ActiveForm;
use common\behaviors\FileBehavior;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Maestrocompo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maestrocompo-form">

    <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
    
     <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
          
          if(!$model->isNewRecord){
            $url=\yii\helpers\Url::to(['/masters/materials/modal-edita-material-sol','id'=>$id]);   
          }else{
             $url=\yii\helpers\Url::to(['/masters/materials/modal-crea-material-sol','id'=>$id]);  
          }
          
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div> 
    
    <BR><BR><BR>
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <?= $form->field($model, 'codart')->
                   textInput(['disabled'=>(!$model->isNewRecord)?true:false,   'maxlength' => true,'value'=>($model->isNewRecord)?$model->generateCode($model->codsubsubfam_):$model->codart]) ?>
</div>  

    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <?= $form->field($model, 'descrimanual')->textInput(['maxlength' => true,'disabled'=>$model->subido]) ?>
</div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>$model->subido]) ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= $form->field($model, 'caracteristicas')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= $form->field($model, 'infotecnica')->textArea([]) ?>
</div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'subido')->checkbox([]) ?>
</div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'activo')->checkbox([]) ?>
</div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'proyecto')->
            dropDownList(comboHelper::getCboProyectosAbiertos() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    </div>    
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= $form->field($model, 'obs')->textArea([]) ?>
</div>
   <?php 
   if(!$model->isNewRecord){
    ?>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true,'disabled'=>true]) ?>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <?= $form->field($model, 'fecha_cre')->textInput(['maxlength' => true,'disabled'=>true]) ?>
</div>
    
    
    <?php 
   }
   ?>
    
</div>    

 <!--This element id should be passed on to options-->

    <?php ActiveForm::end(); ?>
 

    
   
  <?php 
  $valor=($model->isNewRecord)?'1':'0';
  
  
  $this->registerJs(" $('#buscarvalor').on('hidden.bs.modal', function () {
    //console.log('verificando que el model se coulta' );
    //alert('hola amigos');
        
        
        var_codigo=$('#maestrocomposol-codart').val();
        var key_mayor='_'+(parseInt(var_codigo)-1).toString();
        //alert(key_mayor);
         var promesa1= $.ajax({
           url : '".Url::to(['masters/materials/ajax-verifica-cod-sol'])."',
          type : 'GET', 
          data : {codart:var_codigo}, 
          dataType: 'json', 
          success : function(json) {
                            resulta1=json['success'];
                                                  
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        }).then(function(){ 
            if(resulta1['codart']==var_codigo){
               var nuevo_registro='".$valor."';
                   
                        var tree = $('#tree').fancytree('getTree');
                        var node = tree.getNodeByKey('_'+".$model->codsubsubfam_.");
                        node.setSelected(true);
                       // alert('_'+".$model->codsubsubfam_.");
                   if(nuevo_registro=='1'){
                        
                          if(node.isExpanded()){
                               node.addChildren({
                               icon:'fa fa-cube',
                               title:'<i style=\"color:orange;\"><span class=\"fa fa-circle\"></i><span style=\"font-weight:900;\">'+var_codigo+'</span>-'+resulta1['descripcion']+'<a  href=\"/frontend/web/masters/materials/modal-edita-material-sol?id='+var_codigo+'&gridName=grilla-arbol&idModal=buscarvalor\"><i style=\"color:orange;\"><span class=\"fa fa-pencil\"></i></a>',
                               key:'_'+resulta1['codart'],
                               lazy:true,
                                //folder: true
                                },key_mayor); 
                             node = tree.getNodeByKey('_'+resulta1['codart']);
                             //node.setSelected(true);
                            }else{
                               node.setExpanded(true);

                            }
                           
                   }else{
                           if(node.isExpanded()){
                               var node_hijo = tree.getNodeByKey('_'+var_codigo); 
                              if(resulta1['subido']=='1'){
                                  var icono_var='<i style=\"color:#a7da19;\"><span class=\"fa fa-arrow-up\"></i>';
                                }else{
                                 var icono_var='<i style=\"color:orange;\"><span class=\"fa fa-circle\"></i>';
                                }
                               node_hijo.setTitle(icono_var+'<span style=\"font-weight:900;\">'+resulta1['codart']+'</span>-'+resulta1['descripcion']+'<a  href=\"/frontend/web/masters/materials/modal-edita-material-sol?id='+var_codigo+'&gridName=grilla-arbol&idModal=buscarvalor\" class=\"botonAbre\"><i style=\"color:orange;\"><span class=\"fa fa-pencil\"></i></a>');
                              
                              // node_hijo.setSelected(true);
                            }else{
                              node.setExpanded(true); 

                            }
                     
                   }
                        

            } else{
                 
            }
        });





















});

", \yii\web\View::POS_LOAD);
 ?>
</div>
