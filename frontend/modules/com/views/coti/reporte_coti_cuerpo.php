<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;?>
<div style="margin:0px; padding:5px; position:relative; width:100%;  border-width:1px;   border-style:solid;">
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
        <?php 
       
        foreach($partida->detailPadres as $detalle){   ?> 
            <?php  if(!$detalle->mostrar) {   ?>
             <tr>                
                 <td style="width:8%"><p style="font-size:0.8em;"><?=$detalle->item?></p></td>
                 <td style="width:60%"><p style="font-size:0.8em;"><?=$detalle->descripcion?></p></td>
                  <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$detalle->codum?></p></td>
                 <td style="width:8%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->cant,2)?></p></td>
                 <td style="width:7%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->ptotal/$detalle->cant,2)?></p></td>
                 <td style="width:10%; text-align: right;"><p style="font-size:0.8em;"><?=$formato->asDecimal($detalle->ptotal,2)?></p></td>
             </tr>
        <?php 
        
        
            }else{ ?>
                  <?php  foreach($detalle->detail as $detallazo) {  ?>
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