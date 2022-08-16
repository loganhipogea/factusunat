<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
$this->title = Yii::t('rbac-admin', 'Usuarios');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="siteee-login">
    <h6><?= Html::encode($this->title) ?></h6>

    
<div class="box box-success">
<?php

  
echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'items' => [
        [
            'label' => yii::t('base.names','Perfil'),
            'content' => $this->render('profileother',[
                'model'=>$model,'profile'=>$profile]),
            'active' => true,
             'options' => ['id' => 'myveryryyownID2'],
        ],
        [
            'label' => yii::t('base.names','Dominios'),
            'content' => $this->render('_tab_user_dominios',['user_id'=>$model->id]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryownID1'],
            'active' => false
        ],
        /*[
            'label' => yii::t('base.names','Audit'),
            'content' => $this->render('_tab_log',[]),
            'headerOptions' => ['style'=>'font-weight:bold'],
            'options' => ['id' => 'myveryownID2'],
            'active' => false
        ],*/
        
    ],
]);    
    
    ?>

    </div>
</div>
