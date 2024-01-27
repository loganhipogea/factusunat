<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = $model->numero;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Editar'), 'url' => ['edit-os','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="op-procesos-view">

    <h4><?= Html::encode($this->title).'  -  '.Html::encode($model->descripcion) ?></h4>
 <div class="box box-success">
     <p>
        <?= Html::a(Yii::t('app', 'Editar'), ['edita-os', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>
    <?php //echo $this->render('_form_view',['model'=>$model]);  ?>
  </div> 
 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'fechaprog',
            'numero',
           
            'descripcion',
           
            
        ],
    ]) ?>
</div>
