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
    

 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                             'language' => h::app()->language,
                           // 'readonly'=>true,
                          // 'inline'=>true,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                  'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>"-99:+0",
                               ],
                           
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control','disabled'=>$model->hasChilds()]
                            ]) ?>
</div>
<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

</div>
          
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'hinicio')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'hfin')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

 </div>
  
   <?php if(!$model->isNewRecord)  { ?>         
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?php echo  $form->field($model, 'semana')->
                textInput(['disabled'=>true]);?>
 </div>  
   <?php } ?>         
          
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'direcc_id',
         'ordenCampo'=>1,
         'addCampos'=>[2],
        ]);  ?>

 </div> 
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
        <?php echo  $form->field($model, 'proc_id')->
            dropDownList(ComboHelper::procesos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
 </div> 

    <?php if(!$model->isNewRecord)  { ?>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?php echo  $form->field($model, 'esferiado')->
         checkbox(['disabled'=>true]);?>
 </div> 
 <?php } ?>       
       
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?php /*echo ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::procesos(),
               'campo'=>'proc_id',
               'idcombodep'=>'optareo-os_id',
              
                   'source'=>[\frontend\modules\op\models\OpOs::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'proc_id'  
                                ]
                                ],
                            ]
               
               
        ) */ ?>
 </div>       
          
          
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?php /*echo ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?[]:ComboHelper::Os($model->proc_id),
               'campo'=>'os_id',
               'idcombodep'=>'optareo-detos_id',              
                   'source'=>[\frontend\modules\op\models\OpOsdet::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'os_id'  
                                ]
                                ],
                            ]
               
               
        ) */ ?>
 </div> 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?php /*echo  $form->field($model, 'detos_id')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::actividadesOs($model->os_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) */ ?>
 </div> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>
      <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_tareo_pdf',
            'otherContainers'=>['pjax-det'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/op/proc/ajax-build-tareo-pdf','id'=>$model->id]),
            'id_input'=>'btn_fct_aprobar',
            'idGrilla'=>'pjax-det'
      ])  ?>  
           
    <?php Pjax::begin(['id'=>'pjax-det','timeout'=>9000]); ?>
    <?php
    $ext= json_encode(array_merge(Fl::extEngineers(),Fl::extDocs()));

// echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-os',
                'dataProvider' =>new \yii\data\ActiveDataProvider([
                                    'query'=> frontend\modules\op\models\OpLibro::find()->select(['id',
                                        'hinicio','descripcion','tipo',
                                    ])->andWhere(['tareo_id'=>$model->id])
                                ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}{image}',
               'buttons' => [
                    'attach' => function($url, $model) use($ext) {  
                         
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
                            'extension'=>$ext,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                        'image' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/galleryimage',
                             'idModal'=>'imagemodal',                             
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Ver Galería'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['href' => $url, 'title' => 'Visualizar imágenes', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },        
                                
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/op/tareo/modal-edita-libro','id'=>$model->id,'gridName'=>'pjax-det','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-primary glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              
			    },
                       /* 'attach' => function($url, $model) {  
                          $url=\yii\helpers\Url::toRoute(['/op/proc/modal-agrega-doc','id'=>$model->id,'gridName'=>'pjax-det','idModal'=>'buscarvalor']);
                        $options = [
                            'title' => Yii::t('base.names', 'Subir Archivo'),
                            'data-method' => 'get',
                           
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                       
                        },*/
                    ]
                ],
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/op/tareo/ajax-expand-tareo']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 
         ['attribute' => 'hinicio',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->hinicio;                        
                             } 
                
                ],
         
             ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->descripcion;                        
                             } 
                
                ],   
                 ['attribute' => 'tipo',
                'format'=>'raw',
                'value'=>function($model){
                        return $model-> comboValueText('tipo');                        
                             } 
                
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
     
    <?php Pjax::end(); ?>
     
          
          
          
</div>
    </div>
