<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
USE common\helpers\h;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use  common\widgets\selectwidget\selectWidget;
use frontend\modules\mat\helpers\ComboHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>


  <div class="box-body">
      
      
      
      
      
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation'=>true,
    ]); 
    $bloqueado=false;
   $formato=h::formato();
    ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
              <div class="btn-group">  
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
           <?php 
            
          
            echo Html::button( '<span class="fa fa-chek"></span>   '.Yii::t('base.names', 'Calificar ABC'),
                  ['class' => 'btn btn-success','href' => '#','id'=>'btn-abc']
                 );
        
               ?> 
             </div>     
            </div>
        </div>
     </div>

   <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
   <div class="small-box bg-success">
        <div class="inner">
            <h4><?=$formato->asDecimal($model->valor)?></h4>
            <p>Valor total</p>
        </div>
        <div class="icon">
            <i class="fa fa-money"></i>
        </div>
            <a href="#" class="small-box-footer">Detalles<i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
      
 
 <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-warning">
            <div class="inner">
                <h4><?=$model->nItemsStockCuidado()?></h4>
                    <p># Items a reponer</p>
            </div>
            <div class="icon">
                <i class="fa fa-line-chart"></i>
            </div>
                <a href="#" class="small-box-footer">Detalles <i class="fas fa-arrow-circle-right"></i></a>
        </div>
</div>

  <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-danger">
            <div class="inner">
                <h4><?=$model->nItemsStockRoto()?></h4>
                <p># Items stock crítico</p>
            </div>
            <div class="icon">
                <i class="fa fa-warning"></i>
            </div>
                <a href="#" class="small-box-footer">Detalles <i class="fas fa-arrow-circle-right"></i></a>
        </div>
   </div>   

      
      
      
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
     <?= $form->field($model, 'codal')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
 <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8">
     <?= $form->field($model, 'nomal')->textInput(['maxlength' => true,'disabled'=>true  ]) ?>
     
 </div>
      
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
     <?= $form->field($model, 'novalorado')->checkBox([]) ?>
     
 </div>    
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
     <?= $form->field($model, 'tolstockres')->checkBox([]) ?>
     
 </div>    
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
     <?= $form->field($model, 'agregarauto')->checkBox([]) ?>
     
  </div> 
  
  <?php  ActiveForm::end(); ?>
 <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">

   
      
      
    <?php   
       echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn-abc',
            'otherContainers'=>['zona-scripts'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/centros/ajax-calificar-pareto','codal'=>$model->codal]),
            'id_input'=>'btn-abc',
            'idGrilla'=>'grilla-botones',
      ]);  ?>
   
      
</div>
  
  </div>