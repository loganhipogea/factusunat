<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\prd\models\PrdOp */

$this->title = Yii::t('base.names', 'Create Prd Op');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Prd Ops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prd-op-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>