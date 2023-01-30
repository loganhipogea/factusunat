<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
?>
<?php

$simbolo= \common\models\masters\Monedas::Simbolo($model->codmon);
$formato=h::formato();
?>

<!--El logo -->
<div style="position:absolute; left:40px;top:10px; margin:0px;padding:5px;">
    <?=$this->renderFile('@commonweb/logos/logo_bov.php')  ?>
</div>
<!--FIN DEL LOGO-->


<!--El titulo del numero -->
<div style="text-align: center; font-weight: 900; "><u><b>COTIZACIÓN <?= $model->numero ?></u></b></div>
<!--FIN DEL TITULO -->


<div style="position:absolute;  left:40px; top:100px; margin:0px; padding:0px; width:90%; ">

<!--Nombre del cliente y ruc contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Cliente:</b> <?=$model->cliente1->despro?>
        
  
    </div>

<!--FECHA DE EMISION Y MONEDA 50% LADO DERECHO-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Fecha:</b> <?=$model->femision?>  <b>Moneda:</b> <?=$model->codmon?> 
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->


<!--Nombre del contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        <?php if(count($model->contactos)) {  ?>
            <b>Atencion:</b> <?=$model->contactos[0]->contacto->nombres.'/'.$model->contactos[0]->contacto->cargo;?>
        <?php } ?>    
  
    </div>

<!--validez-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Validez:</b> <?=$model->validez.' dias'?>  
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->



 <!--La descripcion -->  
    <div style="width:100%; margin:0px; padding:0px;  font-size:0.75em; ">
        
            <b>Descripción:</b>  <?=$model->descripcion?>
        
 
    </div>
<!--Fin de la descripcion-->

<!--El tenor superior-->
    <div style="width:100%; margin-top:3px;margin-bottom:3px;margin-left:0px;margi-rigth:0px; padding:0px;
          text-align: justify;
        position:relative;
        
        font-size: 0.9em;
        ">
        <?=h::gsetting('com','tenorsup_coti')?>
    </div>
<!--Fin del tenor superior-->

 

<!--Condiciones-->  
<div style="width:90%; margin:0px; padding:0px; font-size:1.1em;">
    
        <b>Condiciones:</b> <?=$model->detalle_externo?>
    
</div>
<!--Fin de las condiciones-->


 