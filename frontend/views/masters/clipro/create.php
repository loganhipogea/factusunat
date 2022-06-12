<?php

use yii\helpers\Html;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */

$this->title = Yii::t('base.verbs', 'Create company');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Customers/Vendors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clipro-create">

    <h4><?=h::awe('plus')?><?=h::awe('building')?><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
           // 'modelDetails' => $modelDetails
    ]) ?>

</div>

</div>