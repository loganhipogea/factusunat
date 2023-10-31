<?php

use common\helpers\h;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
  $bloqueado=$model->isBloqueado();
?>

<?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('base.names','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_modal_tab_detalle_req_mat',
                    ['model' => $model,
                        'id'=>$id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        'bloqueado'=>$bloqueado
                    ]),
                        
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Detalles'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('view_stock',[ 'codart' => $model->codart]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  
?>







