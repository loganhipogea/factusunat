<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use kartik\grid\GridView as grid;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use yii\web\View;
  use common\models\masters\Clipro;
//use common\models\masters\Direcciones;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>

  
    <?php Pjax::begin(['id'=>'grilla-contactos']); ?>
   
   <?php 
   $gridColumns=[
       
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['masters/clipro/editacontacto','id'=>$model->id,'gridName'=>'grilla-contactos','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ],
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'nombres',
            //'pageSummary' => 'Total',
           /* 'editableOptions'=>[
                //'ajaxSettings'=>['data'=>['karina'=>'toledo']],
            ],*/
            /*'vAlign' => 'middle',
            'width' => '210px',*/
           //'data'=>['modelo'=>'mimodelo']
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'mail',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'cargo',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
         
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'moviles',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
   ];
   echo grid::widget([
    'dataProvider'=> $dpContactos,
   // 'filterModel' => $searchModel,
       'summary' => '',
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true
       ]);
   ?> 
   
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'grilla-contactos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>



    <?php Pjax::end(); ?>    
   
<?php
$url= Url::to(['/masters/clipro/createcontact','id'=>$model->codpro,'gridName'=>'grilla-contactos','idModal'=>'buscarvalor']);
 
  echo  Html::button('<span class="fa fa-user"></span>'.yii::t('base.verbs','Crear Contacto'), ['href' => $url, 'title' => 'Nuevo Contacto de '.$model->despro,'id'=>'btn_contacts','idGrilla'=>'grilla-contactos',    'class' => 'botonAbre btn btn-success']); 

  
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
   
   