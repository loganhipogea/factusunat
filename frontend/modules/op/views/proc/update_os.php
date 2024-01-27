<?php


use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use yii\helpers\Url;
use kartik\slider\Slider;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = Yii::t('app', 'Editar OS: {name}', [
    'name' => $model->numero,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordenes'), 'url' => ['index-os']];


?>
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
 <?php
 $form=null;
  $this->render('_form_os_base',[
      'model'=>$model,
      'form'=>$form,
  ]);
?>
  <div class="box-body">
    <?php 
    $items= [
        
       
        [
          'label'=>'<i class="fa fa-puzzle-piece"></i> '.yii::t('base.names','Actividades'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form_os',[
                'model' => $model,
                'form'=>$form,
                //'aprobado'=>$aprobado,
                //'dataProviderMateriales' =>$dataProviderMateriales,
               // 'dataProviderServicios' =>$dataProviderServicios,
                    ]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Materiales'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_materiales_os',
                    [ 
                'model' => $model,
                 'searchModel' => $searchModel,
                 'dataProviderMateriales' =>$dataProviderMateriales,
                //'aprobado'=>$aprobado
                    ]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       [
          'label'=>'<i class="fa fa-wrench"></i> '.yii::t('base.names','Servicios'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_servicios_os',
                    [ 
                'model' => $model,
                 'searchModelServ' => $searchModelServ,
                'dataProviderServicios' =>$dataProviderServicios,
               // 'aprobado'=>$aprobado
                    ]),
            'active' => false,
             'options' => ['id' => 'myveryfsffownID4'],
        ], 
       
        
       
    ];
    if(!empty($model->codart)|| !empty($model->codactivo)){
        $items[]=[
          'label'=>'<i class="fa fa-wrench"></i> '.yii::t('base.names','Estructura'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_estructura',
                    [ 
                'model' => $model,
                 'searchModelServ' => $searchModelServ,
                'dataProviderServicios' =>$dataProviderServicios,
               // 'aprobado'=>$aprobado
                    ]),
            'active' => false,
             'options' => ['id' => 'my7879ownID4'],
        ];
    }
    echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
        'items' =>$items,
]);  
?>
 
  </DIV>
     </DIV>