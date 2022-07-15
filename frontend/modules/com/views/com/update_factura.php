<?php

use yii\helpers\Html;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */

$this->title = Yii::t('base.verbs', 'Update {document}: {number}', [
    'document' =>h::sunat()->graw('s.01.tdoc')->getText($model->sunat_tipodoc),'number' => $model->numero,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Invoices'), 'url' => ['index-invoices-simple']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base.verbs', 'Update');
?>
<div class="clipro-update">

     <h4><?=h::awe('pencil')?><?=h::awe('building')?><?= Html::encode($this->title) ?></h4>

    
<div class="box box-success">
    <?= $this->render('_form_update_factura', [
        'model' => $model,
            
    ]) ?>

</div>
</div>
