<?php
use yii\helpers\Url;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

use common\widgets\inputajaxwidget\inputAjaxWidget;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>





    <?php $form = ActiveForm::begin([
        'id'=>'mycliproform',
        'enableAjaxValidation' => true]); ?>
    
    <div class="box-footer">
        <div class="col-md-12">
            <div class="form-group ">
               
            </div>
        </div>
    </div>
    <div class="box-body">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'rucpro')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
           <div class="form-group field-zona_pk">
                <label class="control-label" for="zona_pk">
                    Despro
                </label>
             
                <input type="text"  
                       id="zona_pk"
                       class="form-control" 
                       value=""
                       name="Clipro[despro]"                       
                       disabled
                  >  
              
            </div>    
    </div>
      
   </div>
    
            <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'clipro-rucpro',
            'idGrilla'=>'zona_pk'
            ])  ?>
      
    <?php ActiveForm::end(); ?>

 
