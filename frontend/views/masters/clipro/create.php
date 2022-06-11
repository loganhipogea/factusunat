<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */

$this->title = Yii::t('base.verbs', 'Create Clipro');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clipros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clipro-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
           // 'modelDetails' => $modelDetails
    ]) ?>

</div>

</div>