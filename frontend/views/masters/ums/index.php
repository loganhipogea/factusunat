<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\UmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Units of measure');
$this->params['breadcrumbs'][] = $this->title;
?>


    <h4><?=h::awe('calculator')?><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="ums-index">
    <p>
        
        <?= Html::a(h::awe('plus').h::awe('calculator').Yii::t('base.verbs', 'Create').' '.Yii::t('base.names', 'Units of measure'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  <div class="box box-success">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'codum',
            'desum',
            'dimension',
            'escala',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
   </div>

</div>
