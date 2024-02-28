<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Modelosbase */

$this->title = Yii::t('app', 'Create Modelosbase');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modelosbases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelosbase-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>