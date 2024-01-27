<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */

$this->title = Yii::t('app', 'Editar Ingreso: {name}', [
    'name' => $model->numero,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ingresos'), 'url' => ['index-ne']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view-ne', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
<div class="mat-req-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
    <div class="box box-success">
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('base.names','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form_ne',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-paperclip"></i> '.yii::t('base.names','Adjuntos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_segunda_ne',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  
?>
</div>
</div>