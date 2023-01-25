<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use kartik\tabs\TabsX;
use yii\grid\GridView as grid;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */

$this->title = Yii::t('app', 'Update Com Cotizacion: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Com Cotizacions'), 'url' => ['index-coti']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="com-cotizacion-update">
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
            'content'=> $this->render('_form_coti',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Partidas'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_partidas',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Colectores'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_cecos',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myvefseryownID4'],
        ],
       [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Cargos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_cargos',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'my5t6vefser54er'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Contacto'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_contacto',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'm45654er'],
        ],
       [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Auditoría'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_audit',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'm45A569n'],
        ],
    ],
]);  ?>

 </div>
 </div>