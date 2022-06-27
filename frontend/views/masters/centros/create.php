<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Centros */

$this->title = Yii::t('base.names', 'Create Centros');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Centros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centros-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>