<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model common\models\masters\Grupostrabajo */

$this->title = Yii::t('app', 'Update Grupostrabajo: {name}', [
    'name' => $model->codgrupo,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grupostrabajos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codgrupo, 'url' => ['view', 'codgrupo' => $model->codgrupo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="grupostrabajo-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
 
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('app','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('app','Tutores'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_adicional',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  

?>
</div>