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
<div style="text-align: center; font-weight: 900; "><u><b>VALE DE ALMACEN <?= $model->numero ?></u></b></div>
<!--FIN DEL TITULO -->


<div style="position:absolute;  left:40px; top:100px; margin:0px; padding:0px; width:90%; ">

<!--Nombre del cliente y ruc contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Cliente:</b> <?=$model->clipro->despro?>
        
  
    </div>

<!--FECHA DE EMISION Y MONEDA 50% LADO DERECHO-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Fecha:</b> <?=$model->fecha?>  <b>Fecha Contable:</b> <?=$model->fechacon?> 
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->


<!--Nombre del contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Detalles:</b> <?=$model->descripcion;?>
        
  
    </div>

<!--validez-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Almacén:</b> <?=$model->codal?>  
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->



<!--Fin de la descripcion-->

<!--El tenor superior-->
    <div style="width:100%; margin-top:3px;margin-bottom:3px;margin-left:0px;margi-rigth:0px; padding:0px;
          text-align: justify;
        position:relative;
        
        font-size: 0.9em;
        ">
        <?=$model->texto?>
    </div>
<!--Fin del tenor superior-->

 

 