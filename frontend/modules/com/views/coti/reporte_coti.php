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
        
        font-size: 0.6em;
        ">
        <?=h::gsetting('com','tenorsup_coti')?>
    </div>
<!--Fin del tenor superior-->

 

<!--Condiciones-->  
<div style="width:90%; margin:0px; padding:0px; font-size:0.7em;">
    
        <b>Condiciones:</b> <?=$model->detalle_externo?>
    
</div>
<!--Fin de las condiciones-->


 <div style="margin:0px; padding:5px; position:relative; width:100%;  border-width:1px;   border-style:solid; font-size:0.75em;">
     <table style="width:100%; background-color: #efefef;"> <tr>
               <th  style="width:8%;">Item</th>
               <th style="width:60%;">Descripcion</th>
               <th style="width:7%;">Um</th>
               <th style="width:8%;">Cant</th>
               <th style="width:7%;">Punit</th>
               <th style="width:10%;">Total</th>
           </tr>
     </table>
     <?php foreach($model->partidas as $partida){   ?>
        <div style="position:relative;  width:60%; float:left; text-align: left; ">
            <b><p style="font-size:0.8em;"><?=$partida->descripartida?></p></b>
        </div>
        <div style="position:relative; float:right; width:40%;text-align:right;">
            <p style="font-size:0.8em;"><b><?=$simbolo.' '.$formato->asDecimal($partida->total,2)?></b></p>
        </div>
     
       <table style="width:100%; border-top-style:solid; border-width:1px; border-color:#efefef;">
          
         
        <?php foreach($partida->detailPadres as $detalle){   ?>
            <?php  if(!$detalle->mostrar) { ?>
             <tr>
                
                 <td style="width:8%"><p style="font-size:0.8em;"><?=$detalle->item?></p></td>
                 <td style="width:60%"><p style="font-size:0.8em;"><?=$detalle->descripcion?></p></td>
                  <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$detalle->codum?></p></td>
                 <td style="width:8%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->cant,2)?></p></td>
                 <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->ptotal/$detalle->cant,2)?></p></td>
                 <td style="width:10%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->ptotal,2)?></p></td>
             </tr>
        <?php  }else{ ?>
                  <?php  foreach($detalle->detail as $detallazo) { ?>
                        <tr>                
                        <td style="width:8%"><p style="font-size:0.8em;"><?=$detallazo->item?></p></td>
                        <td style="width:60%"><p style="font-size:0.8em;"><?=$detallazo->descripcion?></p></td>
                        <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$detallazo->codum?></p></td>
                        <td style="width:8%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detallazo->cant,2)?></p></td>
                        <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detallazo->ptotal/$detallazo->cant,2)?></p></td>
                        <td style="width:10%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detallazo->ptotal,2)?></p></td>
                    </tr>
                  <?php }  ?>
        <?php }  ?>
        <?php }  ?>
       </table>
                 

      <?php }  ?>
  </div>

    
 <div style="margin:0px; padding:0px;  float:right; width:100%;text-align:right;">
            <b><p style="font-size:0.8em;"><b>Total neto: <?=$simbolo.' '.$formato->asDecimal($model->monto-$model->igv,2)?></b></p></b>
 </div>
  
   <div style="margin:0px; padding:0px; float:right; width:100%;text-align:right;">
            <b><p style="font-size:0.8em;"><b>I.G.V.: <?=$simbolo.' '.$formato->asDecimal($model->igv,2)?></b></p></b>
    </div> 
  <div style="margin:0px; padding:0px; float:right; width:100%;text-align:right;">
            <p style="font-size:0.8em;"><b>Total: <?=$simbolo.' '.$formato->asDecimal($model->monto,2)?></b></p>
    </div>   
  

<!--El tenor inferior-->
<br>
    <div style="width:100%; margin-top:3px;margin-left:0px;margi-rigth:0px; padding:0px;;
        position:relative;
         
        font-size: 0.7em;
        ">
        <?=h::gsetting('com','tenorinf_coti')?>
    </div>
<!--Fin del tenor inferior-->
     <?php foreach($model->socio->cuentas as $cuenta){   ?>
          <div style="margin:0px; padding:0px;  float:left; width:100%;text-align:left;">
            <b><p style="font-size:0.8em;"><b>Numero: <?=$cuenta->nombre.' '.$cuenta->numero?></b></p></b>
        </div> 
      <?php  }  ?>
</div>




