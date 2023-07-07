<?php use yii\widgets\ActiveForm;

use yii\helpers\Html;
use yii\helpers\Json;
?>


    <?php
   $form = ActiveForm::begin(['id' => 'registration-form',
        'enableAjaxValidation'=>true
        ]); ?>
   
 <?php    ?>
  <?php echo Html::hiddenInput('grillas',is_array($grillas)?Json::encode($grillas):$grillas); ?>
 <?= \nemmo\attachments\components\AttachmentsInput::widget([
	'id' => 'file-input', // Optional
	'model' => $model,         
	'options' => [ // Options of the Kartik's FileInput widget
                //'language'=>'es-PE', 
		'multiple' => true, // If you want to allow multiple upload, default to false
	//'overwriteInitial'=>false,
            ],
	'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
            
    'allowedFileExtensions'=>$allowedExtensions,
    'maxImageWidth'=>10000,
    'maxImageHeight'=>10600,
    'resizePreference'=>'height',
    'maxFileCount'=>4,
    'resizeImage'=>true,
    'resizeIfSizeMoreThan'=>100,
            'previewFileType' => 'any',
		'maxFileCount' => 4 ,// Client max files
           'overwriteInitial'=>false,
             'maxFileSize'=>1024*1024*30,
            'resizeImages'=>true,
	]
]) ?> 

 <?php ActiveForm::end(); ?>