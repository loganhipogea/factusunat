<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */

$this->title = Yii::t('app', 'Materiales : {name}', [
    'name' =>' A cargar',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Listado requerimientos'), 'url' => ['index']];

$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
<div class="mat-req-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
    <div class="box box-success">
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('base.names','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('arbol_estructural',['arr_arbol' => $arr_arbol]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Detalles'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_listado_sol',[
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider ]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Recientes'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_listado_sol_recientes',[
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider ]),
            'active' => false,
             'options' => ['id' => 'myverygffgownID5'],
        ],
        
       
    ],
]);  
?>
</div>
</div>