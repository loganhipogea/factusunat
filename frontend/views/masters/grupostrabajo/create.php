<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Grupostrabajo */

$this->title = Yii::t('app', 'Create Grupostrabajo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grupostrabajos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupostrabajo-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>