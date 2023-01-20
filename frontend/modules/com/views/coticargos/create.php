<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCargoscoti */

$this->title = Yii::t('app', 'Create Com Cargoscoti');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Com Cargoscotis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="com-cargoscoti-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>