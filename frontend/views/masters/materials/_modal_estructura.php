<?php
 
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\ComboHelper;
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
          
          if($model->isNewRecord){
            $url=\yii\helpers\Url::to(['/masters/materials/crea-estructura','id'=>$id]);   
          }else{
             $url=\yii\helpers\Url::to(['/masters/materials/edita-estructura','id'=>$id]);  
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
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?php  
            $datos=$model->find()->asArray()->all();
            //var_dump($datos,array_column($datos,'id'), array_column($datos,'descri'));die();
            $datos=array_combine (array_column($datos,'id'), array_column($datos,'descri'));
           echo  $form->field($model, 'parent_id')->
            dropDownList($datos,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
     </div>

   
 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <?= $form->field($model, 'item')->textInput(['maxlength' => true]) ?>
</div>
   <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <?= $form->field($model, 'descri')->textInput(['maxlength' => true]) ?>
</div>
  
    
    <?php ActiveForm::end(); ?>  
</div>    

 <!--This element id should be passed on to options-->

  
 

    
 

