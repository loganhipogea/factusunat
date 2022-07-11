<?php

use yii\helpers\Html;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Maestrocompo */

$this->title = Yii::t('base.verbs', 'Update Material: {name}', [
    'name' => $model->descripcion,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codart, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base.verbs', 'Update');
?>
<div class="maestrocompo-update">

      <h4><?=h::awe('pencil')?><?=h::awe('dropbox')?><?= Html::encode($this->title) ?></h4>
<div class="box box-success">



    <?= $this->render('_formfirme', [
        'model'=>$model,
        'probConversiones'=>$probConversiones
            ]) ?>

</div>
    </div>
