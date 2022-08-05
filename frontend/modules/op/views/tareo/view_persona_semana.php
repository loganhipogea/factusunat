<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
$this->title = Yii::t('app', 'Ver detalle: {codtra}', [
    'codtra' => $model->codtra,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tareos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proc_id, 'url' => ['view', 'id' => $model->proc_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>

<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   <div class="op-tareo-view">
    <div class="box box-success">
    
    <?php
      //echo "hla";
        echo $this->render('_form_resumen_semana_persona',['model'=>$model]);
        ?>
   </div>
  </div>