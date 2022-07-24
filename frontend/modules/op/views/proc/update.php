<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

USE yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = Yii::t('app', 'Editar proceso: {name}', [
    'name' => $model->numero,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procesos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
 

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
            'content'=> $this->render('_form',[
                'model' => $model,
              // 'form'=>$form,
              //  'aprobado'=>$aprobado
                    ]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Comercial'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_comercial',[
                'model' => $model,
                //'form'=>$form,
                //'form'=>$form,
              //  'aprobado'=>$aprobado
              ]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Operaciones'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_operaciones',[ 
                'model' => $model,
               // 'aprobado'=>$aprobado,
            'dataProviderOs'=>$dataProviderOs]),
            'active' => false,
             'options' => ['id' => 'myvessry89own4687'],
        ],
        
        [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Repositorio'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_repositorio',[ 
                'model' => $model,
                //'form'=>$form,
                'dataProviderDocs'=>$dataProviderDocs,
                 'searchOsDocs'=>$searchOsDocs
                //'aprobado'=>$aprobado
                    ]),
            'active' => false,
             'options' => ['id' => 'myvessrxxdyownID4'],
        ],
        [
          'label'=>'<i class="fa fa-money"></i> '.yii::t('base.names','Costeo'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_costeo',[
                'model' => $model,
               // 'form'=>$form,
                //'aprobado'=>$aprobado
                    ]),
            'active' => false,
             'options' => ['id' => 'myvess3dsryownID4'],
        ],
       
    ],
]);  
?>
     
</div>