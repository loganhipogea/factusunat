<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\ComboHelper;
use common\helpers\h;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-form">
 
    
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <label class="control-label" for="buscador_id">Explorar</label>
          <input  type="text" id="buscador_id" class="form-control">
      </div>
      <div id="zona_stock" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          
      </div>
       <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,//Devuelve datos Html
            'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST',            
            'evento'=>'keypress',
            'ruta'=>Url::to(['/com/com/ajax-show-stock']),
            'id_input'=>'buscador_id',
            'idGrilla'=>'zona_stock'
      ])  ?>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php $form = ActiveForm::begin([
        'id'=>'Form_general',
        'enableAjaxValidation'=>true
        ]); ?>  
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
             <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tipodoc')->
            dropDownList(ComboHelper::getTablesValues('com_ov.tipodoc') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'rucodni')->textInput(['maxlength' => true]) ?>
        </div>
   
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
          <div class="form-group field-zona_pk">
                <label class="control-label" for="zona_pk">
                    Despro
                </label>
             
                <input type="text"  
                       id="zona_pk"
                       class="form-control" 
                       name="ComOv[despro]"                       
                       disabled
                  >  
              
            </div>   
         
         
           <?php  /*= $form->field($model, 'despro')->textInput([
               'id'=>'zona_pk',
               'disabled'=>true,
               //'value'=>(empty($model->rucodni))?'':$model->clipro->despro,
               'maxlength' => true])*/ ?>   
         
         

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'codcen')->
            dropDownList(ComboHelper::getCboCentros() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'codsoc')->
            dropDownList(['A'=>'SOCIEDAD','B'=>'SOCIEDAD2'] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'tipopago')->
            dropDownList(ComboHelper::getTablesValues('com_ov.tipopago') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
   
        <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
      
            <?php   
            echo $this->render('orden_venta_tabular_plus.php', ['models' => $models]);
            ?>
            <?php ActiveForm::end(); ?>
            <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'comov-rucodni',
            'idGrilla'=>'zona_pk'
            ])  ?>
   </div> 
</div>
  
