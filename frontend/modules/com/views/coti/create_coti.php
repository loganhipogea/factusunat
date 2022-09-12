<?php

use yii\helpers\Html;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */

$this->title = Yii::t('app', 'Crear oferta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ofertas'), 'url' => ['index-coti']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="com-cotizacion-create">

    <h4><?= h::awe('file-text').' - '.Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form_coti', [
        'model' => $model,
    ]) ?>

</div>
</div>