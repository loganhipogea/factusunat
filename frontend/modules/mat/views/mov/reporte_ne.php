<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use common\helpers\ComboHelper;
use common\models\masters\Monedas;
?>
<?php

$formato=h::formato();

 
?>

<!--El logo -->
<div style="position:absolute; left:40px;top:10px; margin:0px;padding:5px;">
    <?php //echo $this->renderFile('@commonweb/logos/logo_bov.php')  ?>
</div>
<!--FIN DEL LOGO-->


<!--El titulo del numero -->
<div style="text-align: center; font-weight: 900; "><u><b>NOTA DE ENTRADA <?= $model->numero ?></u></b></div>
<!--FIN DEL TITULO -->

<!--DIV CONTENEDOR GENERAL-->
<div style="position:absolute;  left:40px; top:100px; margin:0px; padding:0px; width:90%; ">

<!--Nombre del cliente y ruc contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Unidad Origen:</b> <?=$model->centroOrigen->nomcen ?>
        
  
    </div>

<!--FECHA DE EMISION Y MONEDA 50% LADO DERECHO-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Fecha:</b> <?=$model->fecha?>   
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->


<!--Nombre del contactos 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Movimiento:</b> <?=$model->descripcion;?>
          
  
    </div>

<!--validez-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  font-size:0.75em; ">
        
        <b> Unidad destino:</b> <?=$model->centroDestino->nomcen?>  
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->


<!--Nombre del contac 50% de ancho ladoizquierdo-->
    <div style="width:40%; margin:0px; padding:0px; float:left; font-size:0.75em; ">
        
            <b>Documento relacionado:</b> <?=(!empty($model->codocuref))?$model->documentoRef->desdocu:''.'-'.$model->numdocref;?>
          
  
    </div>



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
        <?=$model->detalle?>
    </div>
<!--Fin del tenor superior-->

 

<!--DIV CONTENEDOR DE LA GRILLA -->
 <div style="margin:0px; padding:5px; position:relative; width:100%;  border-width:1px;   border-style:solid;">
     <!--TABLA DE ENCABEZADOS -->
     <table style="width:100%; background-color: #efefef;"> <tr>
               <th  style="width:8%;">Item</th>
               <th  style="width:10%;">Código</th>
               <th style="width:50%;">Descripcion</th>
                <th style="width:8%;">Serie</th>
               <th style="width:4%;">Um</th>
               <th style="width:6%;">Cant</th>              
               <th style="width:30%;">Estado</th>
           </tr>
     </table>
     <!--FIN DE LA TABLA DE ENCABEZADOS -->
     <?php
     $items=0;
     ?>
     
     
       
       <!--TABLA DE DETALLES ITEMS, OJO TIENE LOS MISMOS % ED ANCHURA QUE LOS ENCABEZADOS-->
       <table style="width:100%; border-top-style:solid; border-width:1px; border-color:#efefef;">
          
         
        <?php 
       
        foreach($model->detalles as $deta){   ?>
            <?php    $items++;  ?>
             <?php  $textodetalle=(!empty($deta->detalle))?'<br>'.'<b><p style="font-size:0.8em;">'.$deta->detalle.'</p></b>':''?>

             <tr>
                
                 <td style="width:8%"><p style="font-size:0.8em;"><?=$deta->item?></p></td>
                 <td style="width:10%"><p style="font-size:0.8em;"><?=$deta->codart?></p></td>
                 <td style="width:50%"><p style="font-size:0.8em;"><?=$deta->descripcion.$textodetalle?></p></td>
                 <td style="width:8%"><p style="font-size:0.8em;"><?=$deta->serie?></p></td>
                  <td style="width:4%; text-align: right;"><p style="font-size:0.8em;"><?=$deta->codum?></p></td>
                 <td style="width:6%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($deta->cant,2)?></p></td>
                  <td style="width:30%; text-align: right;"><p style="font-size:0.8em;"><?=$deta->comboValueText('estadomaterial')?></p></td>
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

  <!--El subtotal margen derecho-->  
 <div style="margin:0px; padding:0px;  float:right; width:100%;text-align:right;">
            
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
    
   <?php
     echo $model->currentDateInFormat(true);
   ?>
 </DIV>



