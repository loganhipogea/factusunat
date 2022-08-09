<?php
use yii\helpers\Html;
use yii\helpers\Url;
$url=Url::to(['']);
?>

<div style="margin:3px; padding:15px; border-style: solid; border-width: 1px; border-color: #ccc;" >
    
        
            <div class="pull-left"><?=$model->titulo?></div><div class="pull-right"><?=Html::a('<span class="fa fa-user"></span>',$url,['class'=>'btn btn-sm btn-primary botonAbre'])?></div>
        
    
    
    <div style="margin-top:35px;border-style:solid;border-color: #ccc; border-width: 1px; border-bottom:0px;border-left:0px;border-right:0px;" >
        Este es el contenido del cuerpo, para ue peudas leer esl cotenido no importra 
        <?= Html::img('@web/img/login_wallpaper.jpg',['width'=>"100%",'height'=>"100%"])?>
    </div>
    </div>

