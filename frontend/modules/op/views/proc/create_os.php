<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = Yii::t('app', 'Crear Orden');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ordenes'), 'url' => ['index-os']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-procesos-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
   <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
    <?= $this->render('_form_os_base', [
        'model' => $model,
          'form' => $form,
    ]) ?>
<?php ActiveForm::end(); ?>
</div>
</div>