<?php

use yii\helpers\Html;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Ums */

$this->title = Yii::t('base.verbs', 'Update {param}', [
    'param' => $model->desum,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codum, 'url' => ['view', 'id' => $model->codum]];
$this->params['breadcrumbs'][] = Yii::t('base.verbs', 'Update');
?>
<div class="ums-update">

  <h4><?=h::awe('pencil')?><?=h::awe('calculator')?><?= Html::encode($this->title) ?></h4>
   <div class="box box-success"> 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div></div>
