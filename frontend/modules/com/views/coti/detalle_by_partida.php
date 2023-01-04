<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
use frontend\modules\com\models\ComDetcoti;
?>

<div class="com-cotizacion-form">
    <br>
    <?php 
    $formato=h::formato();
    $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="button-group"> 
                    <?php $url=Url::to(['/com/coti/update-coti','id'=>$modelCoti->id]);?>
                    <?=Html::a('<span class="fa fa-angle-left" ></span>',$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"])?>
                    
            </div>
        </div>
    </div>
      <div class="box-body">
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($modelCoti, 'numero')->textInput(['maxlength' => true,'disabled'=>true]) ?>

   </div> 
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($modelCoti, 'descripcion')->textInput(['maxlength' => true,'disabled'=>true]) ?>

   </div> 
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($modelCoti, 'codpro')->textInput(['value'=>$modelCoti->cliente1->despro,'maxlength' => true,'disabled'=>true]) ?>
   </div>
   <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model, 'id')->textInput(['style'=>'color:#89097d;font-weight:900;','value'=>$model->descripartida,'maxlength' => true,'disabled'=>true]) ?>
   </div>
   <?php Pjax::begin(['id'=>'pjax-monto-partida']);   ?>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'total')->textInput(['style'=>'color:#89097d;font-weight:900;','maxlength' => true,'disabled'=>true]) ?>
   </div>
    <?php Pjax::end();   ?>
    <?php ActiveForm::end(); ?>
   </div>  
   
    <div class="box-body">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php
      $items=[];
      $formato=h::formato();  
      foreach($model->detailPadres as $fila_padre){
          echo $this->render('collapse_detalle_coti',[
              'model'=>$fila_padre,
              'formato'=>$formato,
                  ]);
         /* $items[]=[
              'label'=>$fila_padre->descripcion,
              'content' => $this->renderAjax('collapse_detalle_coti',[ 'formato'=>$formato,'model'=>$fila_padre]),
          ];*/
        }
    ?>   
       <?php 
           /* echo \yii\bootstrap\Collapse::widget([
                'items' => $items,             
            ]);*/
     ?>
     </div>
     </div>
    </div>
