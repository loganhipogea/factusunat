<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */

$this->title = Yii::t('app', 'Visualizar Cuenta: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cc Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cc-cuentas-update">
<h4><i class="fa fa-search"></i><?= Html::encode($this->title) ?></h4>
   
    <div class="box box-success">
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('base.names','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form_view',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Movimientos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_cuentas_movimientos',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  
?>
</div>
</div>
