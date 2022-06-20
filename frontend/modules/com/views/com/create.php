<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */

$this->title = Yii::t('base.names', 'Create Com Ov');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Com Ovs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="com-ov-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'models' => $models,
    ]) ?>

</div>
