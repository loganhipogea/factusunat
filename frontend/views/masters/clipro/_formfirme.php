<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;

  use common\models\masters\Clipro;
use common\models\masters\Direcciones;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>

    

<div class="clipro-form">


<?php
Pjax::begin(['id'=>'zona-pjax-socio']);
$items=[
        [
            'label' => yii::t('base.names','General'),
            'content' => $this->render('_form',['model'=>$model]),
            'active' => true
        ],
        
        [
            'label' => yii::t('base.names','Direcciones'),
            'content' => $this->render('_tab_direcciones',['dpDirecciones'=>$dpDirecciones,'model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryownID2'],
            'active' => false
        ],
        
        [
            'label' => yii::t('base.names','Cuentas'),
            'content' => $this->render('_tab_cuentas',['dpObjetosCliente' =>$dpObjetosCliente ,'model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryowdfgnID3'],
            'active' => false
        ],
        
         
    ];
if(!$model->socio){
  $items[]=
   [
            'label' => yii::t('base.names','Contactos'),
         'content' => $this->render('_tab_contactos',['dpContactos'=>$dpContactos,'model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryownID1'],
            'active' => false
        ]; 
  $items[]= [
            'label' => yii::t('base.names','Materiales'),
            'content' => $this->render('_tab_materiales',['dpMaestroclipro'=>$dpMaestroclipro,'model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryownID3'],
            'active' => false
        ];
        
}else{
   $items[]=
   [
            'label' => yii::t('base.names','Sucursales'),
         'content' => $this->render('_tab_centros',['dpContactos'=>$dpContactos,'model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myve56654ryownID1'],
            'active' => false
        ];  
    $items[]=
   [
            'label' => yii::t('base.names','Socios'),
         'content' => $this->render('_tab_socios',['dpContactos'=>$dpContactos,'model'=>$model]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myve87967ryownID1'],
            'active' => false
        ];  
}


echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'items' =>$items ,
]);    
pjax::end();    
    ?>
    
    
    
    


    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</div>
