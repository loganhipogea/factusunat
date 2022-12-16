<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div style="text-align: center; font-weight: 900; ">SOLICITUD DE COTIZACION <?= $model->numero ?></div>
<BR>
<BR>

<div class="afiliacion">
    <table>
    <TR >
        <TD width="100%" >
            <div >
                <table  >
                 <TR >
                    <TD style="border-top:solid;border-bottom:solid;border-color:#CCC; border-width: 1px;">Sres : </TD>
                    <TD style="padding: 7px;font-family: courier"><?=$model->proveedor->despro?></TD>
                 </TR>
                </TABLE>
            </DIV>
        </TD>
       
    </TR>
    
</table>
</div>
<br>
<br>
<DIV STYLE="">Por favor cotizar los siguientes materiales:</DIV>
<br>
<table style="width:98%;border-left:solid;border-right:solid;border-top:solid;border-bottom:solid;border-color:#CCC; border-width: 1px;">
    <thead>
    <tr>
      <th style=" background-color:#eee;padding:0px;" >Item</th>
      <th style="background-color:#eee;">Cant</th>
      <th style="background-color:#eee;">Um</th>
      <th style="background-color:#eee;">Descripción</th>
    </tr>
   </thead>
   <tbody>
       <?php  foreach ($model->matDetpetoferta as $fila){  ?>
                 <TR >
                     <td style="border-top:solid;border-color:#CCC; border-width: 1px; padding:15px;font-family: courier;">
                         <?=$fila->item?>
                     </td>
                     <td style="border-top:solid;border-color:#CCC; border-width: 1px;font-family: courier;">
                        <?=$fila->cant?> 
                     </td>
                    <td style="border-top:solid;border-color:#CCC; border-width: 1px;font-family: courier;">
                        <?=$fila->codum?>  
                     </td>
                     <td style="border-top:solid;border-color:#CCC; border-width: 1px;font-family: courier;">
                       <?=$fila->descripcion?>
                         <div style="font-size:0.7em;">
                            <?=((is_null($fila->detalle))?'':'--->'.$fila->detalle)?>
                         </div>
                           
                     </td>
                 </TR>
        <?php  } ?>                 
    </tbody>
</TABLE>





