<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\grid\GridView as grid;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>

   <h6><?= Html::encode($this->title) ?></h6>
    <?php Pjax::begin(['id'=> uniqid()/* 'pjax-estructura'*/]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?php
   $gridColumns=[
       
       [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                 'expandIcon'=>'<i style="color:#F86E35"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#F60101"><span class="fa fa-minus-square-o"></span></i>',
                
             
             
             'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
              'detail' => function ($model, $key, $index, $column) {
                            return $this->render('_tab_estructura',[
                                'model'=>$model,
                                'key'=>$key,
                                'index'=>$index]);
                            },                          
                                       
                 
                     //'detailUrl' =>Url::toRoute(['/mat/mat/ajax-show-kardex']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    //'expandOneOnly' => true
                ],
       
       [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/masters/materials/edita-estructura','id'=>$model->id,'gridName'=>'pjax-estructura','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ],
                            
         
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'item',
            //'pageSummary' => 'Total',
            'vAlign' => 'middle',
           // 'width' => '210px',
            
         ],
       
       
       
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descri',
           // 'pageSummary' => 'Total',
            'vAlign' => 'middle',
           // 'width' => '210px',
            
         ],
       
       
   ];
      if(!isset($key))$key=null;
      echo 'key=>'.$key.'<br>';
      $provider=New yii\data\ActiveDataProvider([
        'query'=> frontend\modules\mat\models\MatEstructuracompo::find()->andWhere([
           'parent_id' =>$key
        ]),
          ]);
      echo "Sql ".frontend\modules\mat\models\MatEstructuracompo::find()->andWhere([
           'parent_id' =>$key
        ])->createCommand()->rawSql;
   echo grid::widget([
       'id'=> uniqid(),
       'bootstrap'=>true, 
       'bordered'=>false,
       'hover'=>true,
       'responsive'=>true,
       'tableOptions' =>['class' => 'table table-striped table-dark'],
    'dataProvider'=>$provider,
    
   // 'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true
       ]);
   ?>
    
    <?php 
    //$url= Url::to(['/masters/materials/creaconversion','id'=>$model->codart,'gridName'=>'pjax-con','idModal'=>'buscarvalor']);
 
      //echo  Html::button('Add Conversion', ['href' => $url, 'title' =>yii::t('base.verbs','Create conversion'), 'class' => 'botonAbre btn btn-success']); 

     ?>
   
   
 <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'pjax-estructura',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>  
   
   
        
<?php
$url= Url::to(['/masters/materials/crea-estructura','id'=>$model->codart,'gridName'=>'pjax-estructura','idModal'=>'buscarvalor']);
    
  echo  Html::button('<span class="fa fa-dropbox"></span>'.yii::t('base.verbs','Crear estructura'), ['href' => $url, 'title' =>yii::t('base.verbs','Create conversion'),'id'=>'btn_cdsontacts','idGrilla'=>'pjax-con',    'class' => 'botonAbre btn btn-success']); 

 /* use lo\widgets\modal\ModalAjax;

echo ModalAjax::widget([
    'id' => 'createCompany',
    'header' => 'Create Company',
    'toggleButton' => [
        'label' => 'New Company',
        'class' => 'btn btn-primary pull-right',
        'id'=>'mibotonmodal'
       // 'style'=>'visibility:hidden',
        
    ],
    'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
    'clientOptions' => ['tabindex'=>'','backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);*/
 ?>  
 <?php Pjax::end(); ?>  