<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>

    

<div class="clipro-form">


<?php
Pjax::begin(['id'=>'zona-pjax-socio','timeout'=>false]);
$items=[
        [
            'label' => yii::t('base.names','General'),
            'content' => $this->render('_tab_factura_general',['model'=>$model]),
            'active' => true
        ],
        
        [
            'label' => yii::t('base.names','Reporte'),
            'content' => $this->render('_tab_factura_pdf',['model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryownID2'],
            'active' => false
        ],
        [
            'label' => yii::t('base.names','Sends'),
            'content' => $this->render('_tab_factura_sends',['model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryore67wnID2'],
            'active' => false
        ],
       
         
    ];



echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'items' =>$items ,
]);    
pjax::end();    
    ?>
    
    
    
</div>
