<?php
use yii\helpers\Url;
use yii\helpers\Html;
USE common\helpers\h;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\datetime\DateTimePicker;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Turnos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turnos-form">
    <br>
    <?php $form = ActiveForm::begin([
    //'fieldClass'=>'\common\components\MyActiveField'
        'id'=>'myfprm',
        'enableAjaxValidation' => true,
    ]); ?>
    
   <?php Pjax::begin(['id'=>'cabecera_turno','timeout'=>false]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="btn-group"> 
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
       
        <?php 
        if($model->activo){
            echo Html::button( '<span class="fa fa-remove"></span>   '.Yii::t('base.names', 'Desactivar'),
                  ['class' => 'btn btn-danger','id'=>'btn-activar']
                 ); 
        }else{
            echo Html::button( '<span class="fa fa-check"></span>   '.Yii::t('base.names', 'Activar'),
                  ['class' => 'btn btn-success','id'=>'btn-activar']
                 ); 
        }
                  
        ?>
           <?php $url=Url::to(['/masters/turnos/asigna-turno','id'=>$model->id]);?>
                    <?=Html::a('<span class="fa fa-users" ></span>'.Yii::t('base.names', 'Asignaciones'),$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-warning"])?>
                   
            </div>
        </div>
    </div>
      <div class="box-body">
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?= 
            $form->field($model, 'codarea_id')->
            dropDownList(ComboHelper::getCboAreas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'finicio')->widget(DateTimePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'datetime')  , 
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
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fin')->widget(DateTimePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'datetime')  , 
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
          
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'desturno')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 3]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'activo')->checkbox(['disabled'=>true]) ?>

 </div>
      <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
            //'isHtml'=>true,//Devuelve datos Html
            //'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST', 
            'data'=>['desactivar'=>($model->activo)?'1':'0'],
            'evento'=>'click',
            'ruta'=>Url::to(['/masters/turnos/ajax-desactiva-turno','id'=>$model->id]),
            'id_input'=>'btn-activar',
            'idGrilla'=>'cabecera_turno'
      ])  ?>   
     <?php Pjax::end(); ?>
    <?php ActiveForm::end(); ?>

   <?php if(!$model->isNewRecord) {  ?>      
          
          <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 <?php Pjax::begin(['id'=>'grilla-turnos','timeout'=>false]); ?>
     <?php
   $provider=New \yii\data\ActiveDataProvider([
       'query'=> common\models\masters\Detturnos::find()->select('*')->andWhere(['turno_id'=>$model->id]),
   ]);  
     $dias= common\helpers\timeHelper::daysOfWeek();
   $gridColumns=[
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['masters/turnos/modal-edita-det-turno','id'=>$model->id,'gridName'=>'grilla-turnos','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                       
                        
                    ]
              
                ],
           ['attribute' => 'dia',
                'format'=>'raw',
                //'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model) use($dias){ 
                             return $dias[$model->dia];                                     
                            } 
                
           ],  
       ['attribute' => 'activo',
                'format'=>'raw',
                //'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                             return ($model->activo)?'<i style="color:#a9e272; font-size:1.5em;" ><span class="fa fa-check"></i>':'<i style="color:#fd250d; font-size:1.5em;" ><span class="fa fa-close"></i>';                                     
                            } 
                
           ],  
          ['attribute' => 'hi',
                'format'=>'raw',
                //'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                             return $model->hi;                                     
                            } 
                
           ],  
           ['attribute' => 'hf',
                'format'=>'raw',
                //'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                             return $model->hf;                                     
                            } 
                
           ],  
         
      
   ];
   echo '.'.GridView::widget([
    'dataProvider'=> $provider,
   // 'filterModel' => $searchModel,
    'columns' => $gridColumns,
      // 'summary'=>'',
    //'responsive'=>true,
    //'hover'=>true
       ]);
   ?>
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widget6768gruidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'grilla-direcciones',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>
          
      
          
          
 <?php Pjax::end(); ?>         
          
   <?php } ?>          
</div>
    </div>
