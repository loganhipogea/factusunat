<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\Pagination;
use common\helpers\h;
use yii\widgets\LinkPager;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use frontend\modules\op\helpers\ComboHelper;
 use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
$this->title = Yii::t('base.names', 'Repositorio de archivos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procesos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Visualizar archivos');
?>
<h4><span class='fa fa-file'></span><?= Html::encode($this->title) ?></h4>
<div class="op-procesos-index">
    <div class="box box-success">
    <?php Pjax::begin(); ?>
       <div class="box-body">                    
        <?php $form = ActiveForm::begin([
        'action' => ['render-files'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>   
          <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div> 
           
           
           
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> comboHelper::procesos() ,
               'campo'=>'proc_id',
               'idcombodep'=>'filesearch-os_id',
               
                   'source'=>[\frontend\modules\op\models\OpOs::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'proc_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div> 
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> (empty($model->proc_id))?[]:ComboHelper::Os($model->proc_id),
               'campo'=>'os_id',
               'idcombodep'=>'filesearch-osdet_id',
               
                    'source'=>[\frontend\modules\op\models\OpOsdet::className()=> 
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'os_id'  
                                ]
                                ],
                            ]
                
               
        )  ?>
 </div> 
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
 <?= $form->field($model, 'osdet_id')->
            dropDownList((empty($model->os_id))?[]:ComboHelper::actividadesOs($model->os_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                  ]
                    ) ?>
 </div> 
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <?= $form->field($model, 'titulo') ?>
 </div> 
 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
 <?= $form->field($model, 'codocu')->
            dropDownList(ComboHelper::getCboDocuments(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                  ]
                    ) ?>
 </div> 
           
           
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'cuando')->widget(DatePicker::class, [
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
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'cuando1')->widget(DatePicker::class, [
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
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <?= $form->field($model, 'size') ?>
 </div> 
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <?= $form->field($model, 'size1') ?>
 </div> 
  <?php ActiveForm::end(); ?>
       </div>
        
   <?php
   
   $query =$dataProvider->query ;
    $countQuery = clone $query;
 
    $pages = new Pagination(['totalCount' => $countQuery->count()]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
  // var_dump( $countQuery->count(),$pages->pageCount,$pages->offset,$pages->limit);die();
    
   
      foreach($models as $model){ ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?php    echo $this->render('_cuadro_archivo',['model'=>$model]);?>
         </div> 
      <?php   } ?>
      
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
       <?php   
      echo LinkPager::widget([
            'pagination' => $pages,
            ]);
      
      
      ?>
      </div>  
     <?php Pjax::end(); ?>
    </div>
</div>
    
       