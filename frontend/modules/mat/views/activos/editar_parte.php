<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatActivos */

$this->title = Yii::t('app', 'Update Mat Activos: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mat Activos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="mat-activos-update">
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
            'content'=> $this->render('_partes_principal',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
            'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Planos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_partes_adjunto_planos',[ 'model' => $model,]),
            'active' => false,
             'options' => ['id' => 'myverydsdownID4'],
        ],
       [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Imágenes'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_partes_adjunto_imagenes',[ 'model' => $model,]),
            'active' => false,
             'options' => ['id' => 'myverxx34yownID6'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','No conformidades'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_partes_reclamos',[ 'model' => $model,]),
            'active' => false,
             'options' => ['id' => 'myverxx34yownID6'],
        ],
       
    ],
]);  
?>
</div>
</div>