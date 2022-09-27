<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Trabajadores */

$this->title = Yii::t('base.names', 'Crear sustancia');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Sustancias'), 'url' => ['index-sustancia']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trabajadores-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form_sustancia', [
        'model' => $model,
    ]) ?>

</div>

