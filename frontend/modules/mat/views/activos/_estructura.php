<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\MaestrocompoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>





   <h4><?=h::awe('dropbox')?><?= Html::encode($this->title) ?></h4>
  <?php 
     Pjax::begin(['id'=>'grilla-arbol']);
     Pjax::end();
    ?>
    <div class="box">
       <?php  
       

 echo yii2mod\tree\Tree::widget([
    'items'=>$arr_arbol,                  
            
        ]); ?>
            </div>
