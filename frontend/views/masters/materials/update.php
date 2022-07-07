<?php
use barcode\barcode\BarcodeGenerator;
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
    <?= \barcode\barcode\BarcodeGenerator::widget(); ?>
<?php 
$optionsArray = array(
'elementId'=> 'showBarcode', /* div or canvas id*/
'value'=> '4797001018719', /* value for EAN 13 be careful to set right values for each barcode type */
'type'=>'ean13',/*supported types  ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix*/
 
);

echo BarcodeGenerator::widget($optionsArray); ?>
    <?= $this->render('_formfirme', [
        'model'=>$model,
        'probConversiones'=>$probConversiones
            ]) ?>

</div>
    </div>
