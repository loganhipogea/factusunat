<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
?>
<?php
$simbolo='S/.';
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
    <div style="width:40%; margin:0px; padding:0px; float:left;  ">
        
            <b>Cliente:</b> <?=$model->cliente1->despro?>
        
  
    </div>

<!--FECHA DE EMISION Y MONEDA 50% LADO DERECHO-->
    <div style="width:40%; margin:0px; padding:0px; float:right;  ">
        
        <b> Fecha:</b> <?=$model->femision?>  <b>Moneda:</b> <?=$model->codmon?> 
        
 
    </div>
<!--Fin del nombre cliente fecha y moneda-->


 <!--La descripcion -->  
    <div style="width:100%; margin:0px; padding:0px;  ">
        
            <b>Descripción:</b>  <?=$model->descripcion?>
        
 
    </div>
<!--Fin de la descripcion-->

<!--El tenor superior-->
    <div style="width:100%; margin:0px; padding:0px;
        position:relative;
         background-color:pink;
        font-size: 0.8em;
        ">
        <?=h::gsetting('com','coti_tenorsup')?>
    </div>
<!--Fin del tenor superior-->

 

<!--Condiciones-->  
<div style="width:90%; margin:0px; padding:0px; font-size:0.8em;">
    
        <b>Condiciones:</b> <?=$model->detalle_externo?>
    
</div>
<!--Fin de las condiciones-->


 <div style="margin:0px; padding:0px; position:relative; width:100%;">
      <?php foreach($model->partidas as $partida){   ?>
        <div style="position:relative;  width:60%; float:left; text-align: left; ">
            <b><p style="font-size:0.8em;"><?=$partida->descripartida?></p></b>
        </div>
        <div style="position:relative; float:right; width:40%;text-align:right;">
            <b><p style="font-size:0.8em;"><?=$simbolo.' '.$formato->asDecimal($partida->total,2)?></p></b>
        </div>
     
       <table style="width:100%; border-bottom-style:solid; border-width:1px; ">
           <tr>
               <th></th>
               <th></th>
               <th><b><p style="font-size:0.8em; text-align: right;">Um</p></b></th>
               <th><b><p style="font-size:0.8em;text-align: right;font-weight:800">Cant</p></b></th>
               <th><b><p style="font-size:0.8em; text-align: right;">Punit</p></b></th>
               <th><b><p style="font-size:0.8em; text-align: right;">Total</p></b></th>
           </tr>
         
        <?php foreach($partida->detailPadres as $detalle){   ?>
             <tr>
                 <td style="width:8%"><p style="font-size:0.8em;"><?=$detalle->item?></p></td>
                 <td style="width:60%"><p style="font-size:0.8em;"><?=$detalle->descripcion?></p></td>
                  <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$detalle->codum?></p></td>
                 <td style="width:8%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->cant,2)?></p></td>
                 <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->punit,2)?></p></td>
                 <td style="width:10%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->ptotal,2)?></p></td>
             </tr>
        <?php }  ?>

       </table>
                 

      <?php }  ?>
  </div>

    
 <div style="margin:0px; padding:0px;  float:right; width:100%;text-align:right;">
            <b><p style="font-size:0.8em;">Total neto: <?=$simbolo.' '.$formato->asDecimal($model->montoneto,2)?></p></b>
 </div>
  <?php foreach($model->cargos as $cargo){  ?>
    <div style="margin:0px; padding:0px; float:right; width:100%;text-align:right;">
            <b><p style="font-size:0.8em;"><?=$cargo->cargo->descripcion?> <?=$simbolo.' '.$formato->asDecimal($cargo->monto,2)?></p></b>
    </div>
  <?php  } ?>
   <div style="margin:0px; padding:0px; float:right; width:100%;text-align:right;">
            <b><p style="font-size:0.8em;">I.G.V.: <?=$simbolo.' '.$formato->asDecimal($model->igv,2)?></p></b>
    </div> 
    
    
</div>





