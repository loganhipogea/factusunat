<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use common\helpers\ComboHelper;
use common\models\masters\Monedas;
?>
<?php

$simbolo= \common\models\masters\Monedas::Simbolo('PEN');

$formato=h::formato();
$unidades= ComboHelper::getCboUms(false, $model->ums());
$cadena='';
 foreach($unidades as $clave=>$valor){
     $cadena.=$clave.'=>'.$valor.', ';
 }
 
?>

<!--El logo -->
<div style="position:absolute; left:40px;top:10px; margin:0px;padding:5px;">
    <?=$this->renderFile('@commonweb/logos/logo_bov.php')  ?>
</div>
<!--FIN DEL LOGO-->


<!--El titulo del numero -->
<div style="text-align: center; font-weight: 900; "><u><b>VALE DE ALMACÉN <?= $model->numero ?></u></b></div>
<!--FIN DEL TITULO -->

<!--DIV CONTENEDOR GENERAL-->
<div style="position:absolute;  left:40px; top:100px; margin:0px; padding:0px; width:90%; ">

<!--Nombre del cliente y ruc contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Promotor:</b> <?=$model->clipro->despro?>
        
  
    </div>

<!--FECHA DE EMISION Y MONEDA 50% LADO DERECHO-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Fecha:</b> <?=$model->fecha?>  <b>F Contable:</b> <?=$model->fechacon?> 
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->


<!--Nombre del contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Movimiento:</b> <?=$model->codmov. ' - '.$model->transaccion->descripcion;?>
          
  
    </div>

<!--validez-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Almacén:</b> <?=$model->codal?>  
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->


<!--Nombre del contac 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Documento relacionado:</b> <?=$model->docu->desdocu;?>
          
  
    </div>

<!--validez-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Número Doc:</b> <?=$model->numerodoc?>  
        
 
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
        <?=$model->texto?>
    </div>
<!--Fin del tenor superior-->

 

<!--DIV CONTENEDOR DE LA GRILLA -->
 <div style="margin:0px; padding:5px; position:relative; width:100%;  border-width:1px;   border-style:solid;">
     <!--TABLA DE ENCABEZADOS -->
     <table style="width:100%; background-color: #efefef;"> <tr>
               <th  style="width:8%;">Item</th>
               <th  style="width:15%;">Código</th>
               <th style="width:60%;">Descripcion</th>
               <th style="width:7%;">Um</th>
               <th style="width:8%;">Cant</th>
               <th style="width:7%;">Punit</th>
               <th style="width:10%;">Total</th>
           </tr>
     </table>
     <!--FIN DE LA TABLA DE ENCABEZADOS -->
     <?php
     $items=0;
     ?>
     
     
       
       <!--TABLA DE DETALLES ITEMS, OJO TIENE LOS MISMOS % ED ANCHURA QUE LOS ENCABEZADOS-->
       <table style="width:100%; border-top-style:solid; border-width:1px; border-color:#efefef;">
          
         
        <?php 
       
        foreach($model->detalles as $detalle){   ?>
            <?php    $items++;  ?>
             <tr>
                
                 <td style="width:8%"><p style="font-size:0.9em;"><?=$detalle->item?></p></td>
                 <td style="width:15%"><p style="font-size:0.9em;"><?=$detalle->codart?></p></td>
                 <td style="width:60%"><p style="font-size:0.9em;"><?=$detalle->material->descripcion?></p></td>
                  <td style="width:7%; text-align: right;"><p style="font-size:0.9em;"><?=$detalle->um?></p></td>
                 <td style="width:8%; text-align: right;"><p style="font-size:0.9em;"><?=$formato->asDecimal($detalle->cant,2)?></p></td>
                 <td style="width:7%; text-align: right;"><p style="font-size:0.9em;"><?=$formato->asDecimal($detalle->valor/$detalle->cant,2)?></p></td>
                 <td style="width:10%; text-align: right;"><p style="font-size:0.9em;"><?=$formato->asDecimal($detalle->valor,2)?></p></td>
             </tr>
      
        <?php } //fin del FOR  ?>
        <?php if($items > 20){ $items=0; //Si excede los items romper  la página, pero antes cerrar  ?>
               </table><!--CERRAR LA TABLA DETALLE ITEMS PRIMERO-->
            </div> <!--CERRAR EL CONTENEDOR DE LA GRILLA LUEGO--> 
      </div><!--CERRAR EL DIV CONTENEDOR GENERAL  LUEGO--> 
               
      <!-- SALTO DE PAGINA-->
                <div style="page-break-before:always;">      
                </div>
      <!-- FIN DE SALTO  DE PAGINA-->
    
    <!-- ABRIR EL DIV CONTENEDOR GENERAL EN LA NUEVA PAGINA-->
     <div style="position:absolute;left:40px; top:100px; margin:10px; padding:10px; width:90%; ">
         <!-- ABRIR EL DIV CONTENEDOR DE LA  EN LA NUEVA PAGINA-->
         <div style="margin:0px; padding:5px; position:relative; width:100%;  border-width:1px;   border-style:solid;">
                    <table style="width:100%; background-color: #efefef;"> 
                                <tr>
                                <th  style="width:8%;">Item</th>
               <th  style="width:8%;">Código</th>
               <th style="width:60%;">Descripcion</th>
               <th style="width:7%;">Um</th>
               <th style="width:8%;">Cant</th>
               <th style="width:7%;">Punit</th>
               <th style="width:10%;">Total</th>
                                </tr>
                    </table>
        <!--Debe de abrir una tabla antes de cerrar la condición,porque el for empieza colocando <tr>-->
        <table style="width:100%; border-top-style:solid; border-width:1px; border-color:#efefef;">
            <?php }  ?>
       <!--Al final siempre cerrar la tabla, asi haya cambiado de pagina o no-->
       </table>
                 

      
  </div>

    
 <div style="margin:0px; padding:0px;  float:right; width:100%;text-align:right;">
            <b><p style="font-size:0.8em;"><b>Total movimiento: <?=$simbolo.' '.$formato->asDecimal($model->total(),2)?></b></p></b>
 </div>
  
  

<!--El tenor inferior-->
<br>
</div>


    <div style="width:100%;
         margin-top:3px;
         margin-left:0px;
         margi-rigth:0px;
         padding:0px;;
        bottom: 50;        
        position: fixed;        
        z-index: 5000;         
        font-size: 0.6em;
        ">
        <?php //echo h::gsetting('com','tenorinf_coti')?>
    </div>
<!--Fin del tenor inferior-->


<!--Cuentas de banco-->
<div style="width:100%;
         
         margin-left:0px;
         margi-rigth:0px;
         padding:0px;;
        bottom: 5;        
        position: fixed;        
        z-index: 5000;         
        font-size: 0.9em;
        ">
    
    <?=$cadena?>
 </DIV>



