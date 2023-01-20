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
<div style="position:absolute; left:0px;top:0px; margin:0px;padding:5px;">
    <?=$this->renderFile('@commonweb/logos/logo_bov.php')  ?>
</div>
<!--FIN DEL LOGO-->


<!--El titulo del numero -->
<div style="text-align: center; font-weight: 900; ">COTIZACION <b><?= $model->numero ?></b></div>
<!--FIN DEL TITULO -->

<div style="width:50%; margin:0px; padding:0px;
   position:absolute;
   left:40px; top:80px; background-color:pink;
   font-size: 0.8em;
   ">
    <?=h::gsetting('com','coti_tenorsup')?>
</div>



<!--Nombre del cliente y ruc contactos -->
<div style="width:50%; margin:0px; padding:0px; position:absolute;  left:40px; top:100px; background-color: red;">
   <div style="width:323px; position:relative;  left:0px; top:0px; background-color: green;">
       <b>Cliente:</b> <?=$model->cliente1->despro?>
   </div>
  
</div>
<div style="width:50%; margin:0px; padding:0px; position:absolute;  left:400px; top:100px; background-color: orange;">
   <div style="width:300px; position:relative;  left:0px; top:0px; background-color: green;">
       <b> Fecha:</b> <?=$model->femision?>  <b>Moneda:</b> <?=$model->codmon?> 
   </div>
 
</div>
   
<div style="width:100%; margin:0px; padding:0px; position:absolute;  left:40px; top:140px; background-color: orange;">
    <div style="position:relative;  left:325px; top:0px; background-color:yellow;">
     <b>Descripción:</b>  <?=$model->descripcion?>
   </div>
 
</div>

  
<div style="width:90%; margin:0px; padding:0px; position:absolute;  left:40px; top:160px; background-color: orange;">
    <div style="position:relative;  left:325px; top:0px; background-color:yellow;">
        <b>Condiciones:</b> <div style="font-size:0.8em;"><?=$model->detalle_externo?></div>
   </div>
 <div style="margin:0px; padding:0px; position:relative; width:100%; background-color: red;">
      <?php foreach($model->partidas as $partida){   ?>
        <div style="position:relative;  width:60%; float:left; text-align: left; ">
            <b><?=$partida->descripartida?></b>
        </div>
        <div style="position:relative; float:right; width:40%;text-align:right;">
            <b><?=$simbolo.' '.$formato->asDecimal($partida->total,2)?></b>
        </div>
     
     <table>
        <?php foreach($partida->detailPadres as $detalle){   ?>
             <tr>
                 <td style="width:5%"><p style="font-size: 12px;"><?=$detalle->item?></p></td>
                 <td style="width:50%"><p style="font-size: 12px;"><?=$detalle->descripcion?></p></td>
                 <td style="width:5%"><p style="font-size: 12px;"><?=$formato->asDecimal($detalle->cant,2)?></p></td>
                 <td style="width:5%"><p style="font-size: 12px;"><?=$detalle->codum?></p></td>
                 <td style="width:5%"><p style="font-size: 12px;"><?=$formato->asDecimal($detalle->punit,2)?></p></td>
                 <td style="width:5%"><p style="font-size: 12px;"><?=$formato->asDecimal($detalle->ptotal,2)?></p></td>
             </tr>
        <?php }  ?>

         </table>
                 

      <?php }  ?>
</div>
</div>





