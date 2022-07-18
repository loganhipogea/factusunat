<?php
use yii\helpers\Html;
$this->title = Yii::t('base.names', 'Create credentials');
$this->params['breadcrumbs'][] =
        ['label' => Yii::t('base.names', 'Societys'), 'url' => ['index-daily-cashes']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="com-factura-index">
   
    <h4><?=$this->title?>-<?=$sociedadAttr['despro']?></h4>
    <div class="box box-success">
    <?= $this->render('sunat_form_credentials', [
                'sociedadAttr'=>$sociedadAttr,
                  'model'=>$model
    ]) ?>

    </div>

</div>