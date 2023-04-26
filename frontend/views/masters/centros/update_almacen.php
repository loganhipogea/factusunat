














<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model common\models\masters\Centros */

$this->title = Yii::t('base.names', 'Editar almacén: {name}', [
    'name' => $model->nomal,
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
          'label'=>'<i class="fa fa-home"></i> '.yii::t('base.names','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_almacen_form',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-money"></i> '.yii::t('base.names','Config materiales'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_almacen_materiales',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        [
          'label'=>'<i class="fa fa-truck"></i> '.yii::t('base.names','Inventario'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_almacen_inventarios',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryorerewnID4'],
        ],
       
       
    ],
]);
    
    ?>
</div>
</div>