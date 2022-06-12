<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


  use common\models\masters\Clipro;
use common\models\masters\Direcciones;
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
            <div class="form-group no-margin">
                <div class="btn-group">
                
                <?= Html::submitButton("<span class=\"fa fa-cog\"></span>".($model->isNewRecord) ? 'Grabar' : 'Grabar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
               <?php 
                 
                 if(!$model->isNewRecord){
                     if(!$model->socio){
                 
                  echo Html::button("<span class=\"fa fa-cog\"></span>Convertir a Socio", 
                          [
                              'id'=>'btn_transf_sociedad',
                              'class' => 'btn btn-success']
                          );   
                 }  else{
                     echo Html::button("<span class=\"fa fa-cog\"></span>Revertir sociedad", 
                          [
                              'id'=>'btn_utransf_sociedad',
                              'class' => 'btn btn-warning']
                          );   
                 }}  
                
               ?>
             
               
              </div>  
            </div>
        </div>
    </div>
    <div class="box-body">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'codpro')->textInput(['disabled'=>'disabled','maxlength' => true]) ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
            <?= $form->field($model, 'despro')->textInput(['maxlength' => true]) ?>
    </div>
       <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
                <?= $form->field($model, 'rucpro',['enableAjaxValidation'=>true])->textInput([
                    'maxlength' => true,
                    'disabled'=>($model->hasChilds())?true:false
                    ]) ?>
      </div>
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'telpro')->textInput(['maxlength' => true]) ?>
         </div>
      
          
        
        
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
         </div>
         
   
       
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>
          </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'deslarga')->textarea(['rows' => 6]) ?>
        </div>
   </div>
    
    <?php ActiveForm::end(); ?>

 <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_transf_sociedad',
            //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/ajax-clipro-to-socio','id'=>$model->codpro]),
            'id_input'=>'btn_transf_sociedad',
            'idGrilla'=>'zona-pjax-socio'
      ])  ?>          
       <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_utransf_sociedad',
           //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
               'ruta'=>Url::to(['/masters/clipro/ajax-clipro-to-empresa','id'=>$model->codpro]),'id_input'=>'btn_utransf_sociedad',
            'idGrilla'=>'zona-pjax-socio'
      ])  ?> 

