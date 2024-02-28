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
            $url=\yii\helpers\Url::to(['/masters/modelos-base/modal-crea-raiz','id'=>$id]);   
          }else{
             $url=\yii\helpers\Url::to(['/masters/modelos-base/modal-edita-raiz','id'=>$id]);  
          }
          
           ?>
           <?php 
           
           echo \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      'scriptAfterSuccess'=>" 
                        var promesa1= $.ajax({
           url : '".Url::to(['masters/modelos-base/ajax-obtiene-id-despiece'])."',
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
        }).then(
              function() { 
                 //Construyendo el Url del boton anadair
                var_url_add='".Url::to(['/masters/modelos-base/'])."';
                var_url_add+='?id='+idObtenido+'&gridName=".$gridName."&idModal=".$idModal." ;
               var tree = $('#tree').fancytree('getTree');
                          alert('_'+idObtenido);
                          //alert(tree.getRootNode());
                              tree.getRootNode().addChildren({
                               icon:'fa fa-cube',
                               title:'<i style=\"color:orange;\"><span class=\"fa fa-circle\"></i><span style=\"font-weight:900;\">'+codigo+'</span>-'+descripcion +'<a href='+var_url_add+' class=\'botonAbre badge btn-success \' >',
                               key:'_'+idObtenido,
                               //lazy:true,
                                //folder: true
                                });
               
                   }             

            );
                          
                                
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
    

 <!--This element id should be passed on to options-->

    <?php ActiveForm::end(); ?>
</div>
