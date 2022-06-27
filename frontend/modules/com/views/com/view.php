<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Com Ovs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="com-ov-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('base.names', 'Update'), ['update-invoice', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    
<div class="box-body">
<div>
        <?php if($model->hasAttachments()) { 
       //echo $model::className();die();
       //echo $model->files[0]->urlTempWeb ;
       echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => 700,
                            'height' => 900,
            ]); ?> 
         <?php } ?>
    </div>
    
   
  
  </div>
</div>
