<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Combovalores */

$this->title = Yii::t('base.verbs', 'Create Combovalores');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.verbs', 'Combovalores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="combovalores-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>