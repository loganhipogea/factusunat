<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use kartik\grid\GridView as grid;
  use common\models\masters\Clipro;
use common\models\masters\Direcciones;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>

   <h6><?= Html::encode($this->title) ?></h6>
    <?php Pjax::begin(['id'=>'pjax-con']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?php
   $gridColumns=[
       
       [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'codum',
            'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',
            
         ],
       
       
       
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'valor1',
            'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',
            
         ],
       
       
   ];
   echo grid::widget([
       'id'=>'holas',
       'bootstrap'=>true, 
       'bordered'=>false,
       'hover'=>true,
       'responsive'=>true,
       'tableOptions' =>['class' => 'table table-striped table-dark'],
    'dataProvider'=> $probConversiones,
   // 'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true
       ]);
   ?>
   
   <div class ="table table-striped table-dark "
   
   

   
    
    <?php 
    //$url= Url::to(['/masters/materials/creaconversion','id'=>$model->codart,'gridName'=>'pjax-con','idModal'=>'buscarvalor']);
 
      //echo  Html::button('Add Conversion', ['href' => $url, 'title' =>yii::t('base.verbs','Create conversion'), 'class' => 'botonAbre btn btn-success']); 

     ?>
     
        
<?php
$url= Url::to(['/masters/materials/creaconversion','id'=>$model->codart,'gridName'=>'pjax-con','idModal'=>'buscarvalor']);
 
     
  echo  Html::button('<span class="fa fa-dropbox"></span>'.yii::t('base.verbs','Crear Conversion'), ['href' => $url, 'title' =>yii::t('base.verbs','Create conversion'),'id'=>'btn_cdsontacts','idGrilla'=>'pjax-con',    'class' => 'botonAbre btn btn-success']); 

  
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