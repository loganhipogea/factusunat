<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
       <div class="col-md-12">
            <div class="btn-group"> 
          <?php Pjax::begin(['id'=>'grilla-botones']);  ?>      
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
         <?php if(!$model->isNewRecord){?>                    
                    <?php $url=Url::to(['/com/coti/make-pdf','id'=>$model->id]);?>
                    <?=Html::a('<span class="fa fa-file-pdf-o" ></span>'.Yii::t('app', 'Pdf'),$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-warning"])?>
                    <?php }?>    
                <?php
          echo Html::button("<span class=\"fa fa-clone\"></span>Version", 
                          [
                              'id'=>'btn_version',
                              'class' => 'btn btn-warning']
                          );
         if(!$model->isAprobed()){
             echo Html::button("<span class=\"fa fa-check\"></span>Aprobar", 
                          [
                              'id'=>'btn_aprobar',
                              'class' => 'btn btn-info']
                          );
         }else{
             echo Html::button("<span class=\"fa fa-undo\"></span>Desaprobar", 
                          [
                              'id'=>'btn_desaprobar',
                              'class' => 'btn btn-danger']
                          );
         }
         ?> 
            <?php Pjax::end();  ?>   
            </div>
        </div>
    </div>
      <div class="box-body">
          
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'serie')->
            dropDownList($model::dataComboValores('serie') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        
              //'disabled'=>$deshabilitado
                        ]
                    ) ?>
 </div>   
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fpago')->
            dropDownList($model::dataComboValores('fpago') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        
              //'disabled'=>$deshabilitado
                        ]
                    ) ?>
 </div>  
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'sumaopunit')->
            dropDownList($model::dataComboValores('sumaopunit') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        
              //'disabled'=>$deshabilitado
                        ]
                    ) ?>
 </div>  
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codmon')->
            dropDownList(\common\helpers\ComboHelper::getCboMonedas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",                    
                        ]
                    ) ?>

 </div>
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'validez')->textInput() ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
       <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codcli',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
       <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codcli1',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>        
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
       <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3,4],
        ]);  ?>

 </div>         
   <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'femision')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                            //   'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>

 </div>
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
   <?= $form->field($model, 'version')->textInput(['disabled'=>true]) ?>

   </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP
     echo $form->field($model, 'detalle_interno')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
 </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP
     echo $form->field($model, 'detalle_externo')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
 </div>
          
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP
     echo $form->field($model, 'memoria')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
 </div>
    <?PHP  
    
    
    ?>
  
     
    <?php ActiveForm::end(); ?>
<?php  echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_versisson',
            //'otherContainers'=>[$send_zone],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/com/coti/ajax-create-version','id'=>$model->id]),
            'id_input'=>'btn_version',
            'idGrilla'=>'grilla-contactos',
      ]); 
?>
<?php 
 Pjax::begin(['id'=>'zona-scripts']);
 if(!$model->isAprobed()){
     echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_aprobar',
            'otherContainers'=>['zona-scripts'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/com/coti/ajax-aprobar-coti','id'=>$model->id]),
            'id_input'=>'btn_aprobar',
            'idGrilla'=>'grilla-botones',
      ]); 

 }else{
    echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_desaprobar',
            'otherContainers'=>['zona-scripts'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/com/coti/ajax-desaprobar-coti','id'=>$model->id]),
            'id_input'=>'btn_desaprobar',
            'idGrilla'=>'grilla-botones',
      ]); 
 Pjax::end();
 }
?>
</div>
    </div>
