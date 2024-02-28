<?php
use yii\helpers\Url;
use yii\helpers\Html;
//use kartik\tabs\TabsX;
//use yii\bootstrap4\ActiveForm;
//use frontend\modules\cc\helpers\comboHelper;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use kartik\grid\GridView;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
//ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model common\models\masters\Turnos */
?>
        
        
        
   <?php $grilla='grilla-asignaciones' ?>
          
        
     <?php Pjax::begin(['id'=>$grilla,'timeout'=>false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?php
     
     
     $dataProvider=New ActiveDataProvider([
                                'query' => common\models\masters\Turnoscambio::find()->
                                            select(['id','ingreso','descripcion','fecha','fecha_ingreso_prog','aprobado','codocuref','numdocuref','codmotivo','codmotivo'])->
                                            andWhere(['turnosasignaciones_id'=>$model->id])-> 
                                            orderBy(['fecha'=>SORT_DESC]),
         
                                            ]);
   $gridColumns=[
       
           
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{aprobar}',
               'buttons' => [  
                       'edit' => function ($url,$model) use($grilla) {
			    $url= Url::to(['masters/turnos/modal-edita-cambio','id'=>$model->id,'gridName'=>$grilla,'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre btn ']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-elimina-permiso','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class=" danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','class'=>'btn ','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                          'aprobar' => function ($url,$model) {                             
                                 $accion=($model->aprobado)?'0':'1';//Es al reves OJO
                                 $estilo=($model->aprobado)?'thumbs-down':'thumbs-up';
                                 $url = \yii\helpers\Url::to([$this->context->id.'/ajax-aprueba-permiso','id'=>$model->id,'aprobar'=>$accion]);
                              
                                
                                return \yii\helpers\Html::a('<span class=" danger glyphicon glyphicon-'.$estilo.'"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas2','class'=>'btn ','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                    ]
              
                ],
                            
         /* ['attribute' => '',
                'format'=>'raw',
                'value'=>function($model){ 
                             return ($model->ingreso >0)?'<i style="color:#a9e272; font-size:1.5em;" ><span class="fa fa-arrow-down"></i>':'<i style="color:#fd250d; font-size:1.5em;" ><span class="fa fa-arrow-up"></i>';                                     
                            } 
                
           ],  */                  
                            
           'descripcion',
           [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'fecha',
           
            
         ],
           'fecha_ingreso_prog',  
                   
        [
             'attribute' => 'intervalo',
                'format'=>'raw',
                //'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                             return $model->lapso();                                     
                            } 
                
           ],   
        [
             'attribute' => 'codmotivo',
                'format'=>'raw',
                //'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                             return $model->comboValueText('codmotivo');                                     
                            } 
                
           ],   
       [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'fcierre',
           'editableOptions'=>[
               'inputType' => (function($model){ return $model->soyElMasReciente();})?Editable::INPUT_DATETIME:Editable::BS_LABEL,
               'asPopover' => false,
                'inlineSettings' => [
                'templateBefore' => Editable::INLINE_BEFORE_2, 
                'templateAfter' =>  Editable::INLINE_AFTER_2
                                ],
           ],
            
         ],  
       [
           'attribute' => 'aprobado',
                'format'=>'raw',
           'value'=>function($model){ 
                             return Html::checkbox($model->id.'chk', $model->aprobado);                                     
                            } 
        //'class' => 'yii\grid\CheckboxColumn',
         //'contentOptions'=>['checked'=>($model->aprobado)],
        // you may configure additional properties here
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
        'otherContainers'=>['cabecera'],
            'idGrilla'=>$grilla,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widget6768gruidBancos',
       'otherContainers'=>['cabecera'],
            'idGrilla'=>$grilla,
            'family'=>'holas2',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>
   <?php Pjax::end(); ?>
     <?php $url=Url::toRoute(['masters/turnos/modal-agrega-cambio','id'=>$model->id,'gridName'=>'grilla-asignaciones','idModal'=>'buscarvalor',]);   ?>
   <?php  
     echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar cambio'), ['href' => $url, 'title' => '','id'=>'btn_adrtrtrteses',    'class' => 'botonAbre btn btn-success']); 
  // echo  Html::button(yii::t('base.verbs','Createx'), ['href' => $url, 'title' => 'Nueva direccion de '.$model->despro,'id'=>'btn_ad3435dresses', 'class' => 'botonAbre btn btn-success']);
     ?>
    
  
       
    
    
    