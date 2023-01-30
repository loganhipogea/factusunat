<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
?>

    
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
         
        font-size: 0.9em;
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




