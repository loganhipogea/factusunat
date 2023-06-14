<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sociedades */

$this->title = Yii::t('base.names', 'Create Worker');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Worker'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sociedades-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
