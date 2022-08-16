
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use common\helpers\h;
use common\helpers\ComboHelper;

use common\widgets\selectwidget\selectWidget;
use yii\widgets\ActiveForm;
$this->title = 'Profile';
//$this->params['breadcrumbs'][] = $this->title;
?>

    <br>
    <?php
     $form=ActiveForm::begin([ 
         'id' => 'profile-form',
         'enableAjaxValidation'=>true,
         
         'options' => ['enctype' => 'multipart/form-data']]);
     ?>
    <div class="form-group">
      <div class="btn-group"> 
        <?= Html::submitButton(Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    
    
    <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">              
            <?php /*h::user()->switchIdentity($identidad);*/ ?>
            
             
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <?php
               if($profile->hasAtachment()){ ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
              <?= \common\widgets\imagewidget\ImageWidget::widget(['name'=>'imagenrep','model'=>$profile]); ?>
     </div>
             <?php  }else{
                 //echo $profile->getUrlImage();die();
                 echo Html::img($profile->getUrlImage(), ['class'=>"img-thumbnail"]);
               }
              
               
              ?>
                    </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= Html::label(yii::t('base.names','User id'),'45545ret',['class' => 'control-label']) ?>
                <?=  Html::input('text', 'username', $model->username,['disabled'=>'disabled','class' => 'form-control']) ?>
             </diV>
            
             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= Html::label(yii::t('base.names','Last Login'),'fd5656',['class' => 'control-label']) ?>
                <?=  Html::input('text', 'username', $model->lastLoginForHumans(),['disabled'=>'disabled','class' => 'form-control']) ?>
             </diV>
            
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= Html::label(yii::t('base.names','Created at'),'fdtt5656',['class' => 'control-label']) ?>
                <?=  Html::input('text', 'username', $model->getSince(),['disabled'=>'disabled','class' => 'form-control']) ?>
             </diV>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?php echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$profile,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>2,
         'addCampos'=>[3,4,5],
        'inputOptions'=>[/*'enableAjaxValidation'=>true*/],
        ]);
           ?>
         </diV>       
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= Html::label(yii::t('base.names','E-mail'),'fd56t56',['class' => 'control-label']) ?>
                <?=  Html::input('text', 'username', $model->email,['disabled'=>'disabled','class' => 'form-control']) ?>
             </diV>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= Html::checkbox('agreeff', false, [ 'disabled'=>'disabled', 'label' =>yii::t('base.names','Enabled')]) ?>
             </diV>
          
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($profile, 'names')->textInput(['disabled'=>'disabled']) ?>
                    </diV>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($profile, 'duration')->textInput(['disabled'=>'disabled']) ?>
                    </diV>
            
             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($profile, 'durationabsolute')->textInput(['disabled'=>'disabled']) ?>
                    </diV>
            
              <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= $form->field($profile, 'tipo')->
            dropDownList($profile->dataComboValores('tipo'),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                     //'class'=>'probandoSelect2',
                        ]
                    ) ?>

                    </diV>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            

 <?= $form->field($model, 'status')->
            dropDownList($model->dataComboStatus(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                     //'class'=>'probandoSelect2',
                        ]
                    ) ?>
                
                    
                </div>
              

 
               
                
           
            
            
        </div>
    </div>
 <?php
     ActiveForm::end();
     ?>

