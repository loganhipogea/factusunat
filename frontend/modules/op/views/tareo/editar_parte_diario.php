<?php
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\h;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
USE common\helpers\FileHelper as Fl;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\widgets\ActiveForm;
use frontend\modules\op\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use kartik\editable\Editable;

  
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpTareo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-tareo-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group">
               <div class="btn-group">  
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?php  echo Html::button("<span class=\"fa fa-cog\"></span>Report", 
                          [
                              'id'=>'btn_fct_aprobar',
                              'class' => 'btn btn-danger']
                          );       
                        ?>
            </div>
             </div>
        </div>
    </div>
      <div class="box-body">
    

<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codtra')->textInput(['disabled' => true,'value'=>$model->trabajador->ap])->label('Trabajador') ?>

</div>

<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'fecha')->textInput(['disabled' => true,]) ?>

</div>
 
  

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-os',
                'dataProvider' =>new \yii\data\ActiveDataProvider([
                                    'query'=> frontend\modules\op\models\ResefParteDet::find()
                        ->andWhere(['parte_id'=>$model->id])
                                ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{delete}',
               
                ],
       
               [
                        'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'area_id',
                             'editableOptions'=> [
                                 //'asPopover' => false,
                                   
                                     'inputType' => Editable::INPUT_DROPDOWN_LIST,
                                        'data'=> ComboHelper::areas(),
                                         'displayValueConfig'=>ComboHelper::areas(),
                                            ]  ,                     
                  
                                           
                   'value'=>function($model){
                        return $model->nombreArea();                        
                             } 
                    ],                       
                                    
                                
                                    
                                    
         ['attribute' => 'hinicio',
                'format'=>'raw',
                 'headerOptions' => ['style' => 'width:10%'],
               'class' => 'kartik\grid\EditableColumn',
             'editableOptions'=> [
                                'inputType' =>Editable::INPUT_TIME,
                                'options' => [
                                        'pluginOptions' => [
                                         'showSeconds' => false,
                                        'showMeridian' => false,
                                        'minuteStep' => 5,
                                       
                                        ]
                                        
                                        ]
                          ]  ,    
             
                'value'=>function($model){
                        return $model->hinicio;                        
                             } 
                
                ],
          ['attribute' => 'hfin',
                'format'=>'raw',
                 'headerOptions' => ['style' => 'width:10%'],
               'class' => 'kartik\grid\EditableColumn',
             'editableOptions'=> [
                                'inputType' =>Editable::INPUT_TIME,
                                'options' => [
                                        'pluginOptions' => [
                                         'showSeconds' => false,
                                        'showMeridian' => false,
                                        'minuteStep' => 5,
                                       
                                        ]
                                        
                                        ]
                          ]  ,    
             
                'value'=>function($model){
                        return $model->hfin;                        
                             } 
                
                ],
         
            [
               
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'actividad',
        'headerOptions' => ['style' => 'width:60%'],
       
    ],
                      
           
        ],
    ]); ?>
    <?php
      $url= Url::to(['modal-agrega-libro','id'=>$model->id,'gridName'=>'pjax-det','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar operación'), 
           ['href' => $url, 'title' => yii::t('base.names','Agregar Op'),
               'id'=>'btn_cuentas_edi',
               'class' => 'botonAbre btn btn-primary'
               ]); 
    ?>
   
    
</div>
    
  </div>        
     
   
          
          
          
</div>
    </div>
