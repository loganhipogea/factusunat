<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\bootstrap4\ActiveForm;
use frontend\modules\cc\helpers\comboHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model common\models\masters\Turnos */

$this->title = Yii::t('app', 'Update Turnos: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Turnos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="turnos-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
    <div class="box box-success">
       <div class="turnos-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      
      <div class="box-body">
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= 
            $form->field($model, 'codarea_id')->
            dropDownList(ComboHelper::getCboAreas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>true,
                        ]
                    )  ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'desturno')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 3,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'activo')->checkbox(['disabled'=>true]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

       
</div>
    <div>
        
        
        
    </div><?php $grilla='grilla-asignaciones' ?>
          
        
     <?php Pjax::begin(['id'=>$grilla,'timeout'=>false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?php
     
     
     $dataProvider=New ActiveDataProvider([
                                'query' => \common\models\masters\VwTurnosAsignaciones::find()->
                                            select(['id','codigotra','nombres','codcuadrilla','descricuadrilla','codarea','desarea','actiasignado'])->
                                            andWhere(['idturno'=>$model->id]),
         
                                            ]);
   $gridColumns=[
       
           
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{view}',
               'buttons' => [  
                       'edit' => function ($url,$model) use($grilla) {
			    $url= Url::to(['masters/clipro/edit-direccion','id'=>$model->id,'gridName'=>$grilla,'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class=" danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                        'view' => function ($url,$model) {
			    $url= Url::to(['masters/turnos/asignado','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-search"></span>', $url, ['data-pjax'=>'0']);
                            },
                    ]
              
                ],
           'codigotra',
           [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'nombres',
           
            
         ],
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'actiasignado',
            'format'=>'raw',
             'value'=>function($model){
                                    //var_dump($model->actiasignado);die();

                return ($model->actiasignado)?'<i style="font-size: 1em; color:#a9e272;"><span class="fa fa-check"></span></i>':'<i style="color:#fd250d; font-size:1em;" ><span class="fa fa-close"></i>';

               
                }
            
         ],
           'codcuadrilla',                 
        [
             'attribute' => 'descricuadrilla',
                'format'=>'raw',
                //'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                             return $model->descricuadrilla;                                     
                            } 
                
           ],                       
       
   ];
           
   echo GridView::widget([
    'dataProvider'=> $dataProvider,
   //'filterModel' => $searchModel,
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
            'idGrilla'=>$grilla,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>
   <?php Pjax::end(); ?>
     <?php $url=Url::toRoute(['masters/turnos/modal-asigna-trabajador','id'=>$model->id,'gridName'=>'grilla-asignaciones','idModal'=>'buscarvalor',]);   ?>
   <?php  
     echo  Html::button('<span class="fa fa-user"></span>'.yii::t('base.verbs','Agregar trabajador'), ['href' => $url, 'title' => '','id'=>'btn_adrtrtrteses',    'class' => 'botonAbre btn btn-success']); 
  // echo  Html::button(yii::t('base.verbs','Createx'), ['href' => $url, 'title' => 'Nueva direccion de '.$model->despro,'id'=>'btn_ad3435dresses', 'class' => 'botonAbre btn btn-success']); ?>
    
  
       
    
    
    
    
    
    
    
    
    
    
    
    
    </div>
     </div>
</div>