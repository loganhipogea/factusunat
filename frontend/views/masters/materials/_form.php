<?php

use yii\helpers\Html;
use common\helpers\ComboHelper;
use yii\widgets\ActiveForm;
use common\behaviors\FileBehavior;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Maestrocompo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maestrocompo-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codart')->textInput(['disabled'=>'disabled','maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= \common\widgets\imagewidget\ImageWidget::widget(['name'=>'imagenrep','model'=>$model,'ancho'=>200,'alto'=>200]); ?>
   </div>
    
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'numeroparte')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    
    <?= $form->field($model, 'codum')->
            dropDownList(ComboHelper::getCboUms() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>($model->isBlockedField('codtipo'))?'disabled':null,
                        ]
                    ) ?>
       
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'peso')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'esrotativo')->checkbox() ?>
    </div>
    
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codtipo')->
            dropDownList(ComboHelper::getTablesValues('maestrocompo.codtipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
</div>
   
    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
   $form = ActiveForm::begin(['id' => 'registration-form',
        'enableAjaxValidation'=>true
        ]);
   
   ?>
 

 <?= \nemmo\attachments\components\AttachmentsInput::widget([
	'id' => 'file-input', // Optional
	'model' => $model,         
	'options' => [ // Options of the Kartik's FileInput widget
                //'language'=>'es-PE', 
		'multiple' => false, // If you want to allow multiple upload, default to false
	//'overwriteInitial'=>false,
            ],
	'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
            
    //'allowedFileExtensions'=>['jpg','png','gif','jpeg'],
    'maxImageWidth'=>10000,
    'maxImageHeight'=>10600,
    'resizePreference'=>'height',
    'maxFileCount'=>1,
    'resizeImage'=>true,
    'resizeIfSizeMoreThan'=>100,
            'previewFileType' => 'any',
		'maxFileCount' => 1 ,// Client max files
           'overwriteInitial'=>false,
             //'maxFileSize'=>800,
            'resizeImages'=>true,
	]
]) ?> 

<div class="form-group">
        
        <?= Html::submitButton('<span class="glyphicon glyphicon-paperclip"></span>'.'   '.Yii::t('base.verbs', 'Adjuntar'), ['class' => 'btn btn-success','data-pjax'=>true]) ?>
    </div>
 <?php ActiveForm::end(); ?>