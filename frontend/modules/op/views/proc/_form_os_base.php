 <?php
 use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use yii\helpers\Url;
use kartik\slider\Slider;       
USE frontend\modules\op\helpers\ComboHelper;
use dosamigos\chartjs\ChartJs;
 ?>

   
    
    
   
     <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
                 
 <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">         
           <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
     
     
           
           <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?=$form->field($model, 'tipoes')->
            dropDownList($model->dataComboValores('tipoes') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>(!$model->isNewRecord)?'disabled':null,
                        ]
                    )  ?>

     </div>
     
     
   <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

   </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'fechaprog')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               //'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'fechaini')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                              // 'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'finprog')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               //'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
     
     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'fin')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                              // 'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    /*echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  */ ?>

 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codart',
         'ordenCampo'=>2,
         'addCampos'=>[2,],
        ]);  ?>

 </div> 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'cant')->textInput(['maxlength' => true]) ?>

 </div>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= 
            $form->field($model, 'codcen')->
            dropDownList(ComboHelper::getCboCentros() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= 
            $form->field($model, 'codcencli')->
            dropDownList(ComboHelper::getCboCentros() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

 </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'orden')->textInput(['maxlength' => true]) ?>

 </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'ot')->textInput(['maxlength' => true]) ?>

       
     
 </div> 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codactivo',
         'ordenCampo'=>1,
         'addCampos'=>[2,5],
        'options'=>[]
        ]);  ?>

 </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'serie')->textInput(['maxlength' => true]) ?>

       
     
 </div> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
   <?php  echo Slider::widget([
      'id'=>'sliderot',
    'sliderColor' => Slider::TYPE_DANGER,
    'handleColor' => Slider::TYPE_DANGER,
    'model'=>$model,
       'attribute'=>'avance',
    'pluginOptions' => [
        'orientation' => 'horizontal',
        'handle' => 'round',
        'min' => 0,
        'max' => 100,
        'step' => 1
    ],
       'pluginEvents' => [   
                         'slideStop' => 'function() {console.log($("#sliderot").slider( "option", "NewValue" )); }',   
                    ]
]);
   ?>
   </div> 
 </div> 
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">  
     <div>
        <?PHP 
                    
 ECHO ChartJs::widget([
     'id'=>'dsdsdskfs',
    'type' => 'doughnut',
    'options' => [
        'height' => 10,
        'width' => 10
    ],
    'data' => [
        'labels' =>['Avanzado','Pendiente'],
        'datasets' => [
           [
                'data' => [$model->avance,100-$model->avance],
                'label' => '',
                'backgroundColor' => ['#FF339A','#F2F2F2'],
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 0,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
            
        ]
    ]
]);
   
?> 
     </div>
 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
    echo $form->field($model, 'textointerno')->textArea(['maxlength' => true]) 
      ?>

 </div>
   

      </DIV><!-- comment -->
