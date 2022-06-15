<?php

use yii\helpers\Html;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Ums */

$this->title =Yii::t('base.verbs', 'Create').' '.Yii::t('base.names', 'Units of measure');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="ums-create">
  <h4><?=h::awe('plus')?><?=h::awe('calculator')?><?= Html::encode($this->title) ?></h4>
   <div class="box box-success"> 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>