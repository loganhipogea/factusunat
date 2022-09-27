<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatPetoferta */

$this->title = Yii::t('app', 'Create Mat Petoferta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mat Petofertas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mat-petoferta-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
        'items'=>$items,
    ]) ?>

</div>
</div>