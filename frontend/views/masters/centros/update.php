<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model common\models\masters\Centros */

$this->title = Yii::t('base.names', 'Update Centros: {name}', [
    'name' => $model->codcen,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Centros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codcen, 'url' => ['view', 'codcen' => $model->codcen]];
$this->params['breadcrumbs'][] = Yii::t('base.names', 'Update');
?>
<div class="centros-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
    <div class="box box-success">
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('base.names','Home'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-money"></i> '.yii::t('base.names','Commerce'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_ventas',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        [
          'label'=>'<i class="fa fa-truck"></i> '.yii::t('base.names','Transport'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_transporte',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryorerewnID4'],
        ],
       [
          'label'=>'<i class="fa fa-industry"></i> '.yii::t('base.names','Warehouses'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_almacenes',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'm34yorerewnID4'],
        ],
       
    ],
]);  
?>