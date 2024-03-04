<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\prd\models\PrdPlanos */

$this->title = Yii::t('app', 'Create Prd Planos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prd Planos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prd-planos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>