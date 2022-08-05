<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
  <?=Html::img(Url::base().'/img/logo_cabecera.png')?>
<div class="titulo">REPORTE TAREO DIARIO</div>
<div class="subtitulo">I DATOS GENERALES</div>
<div class="afiliacion">
    <table>
    <TR >
        <TD width="100%" >
            <div >
                <table >
                 <TR style="border-top:solid;border-bottom:solid;border-color:#CCC; border-width: 1px;">
                    <TD style="padding: 7px;">Nombres y apellidos : </TD>
                    <TD style="padding: 7px;"><?=$alumno->fullName()?></TD>
                </TR>
                
                <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                    <TD style="padding: 7px;">Código :</TD>
                    <TD style="padding: 7px;"><?=$alumno->codalu?></TD>
                </TR>
                 <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                    <TD style="padding: 7px;">Facultad :</TD>
                    <TD style="padding: 7px;"><?=$alumno->facultad->desfac?></TD>
                </TR>
                  <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                   <TD style="padding: 7px;">Especialidad :</TD>
                    <TD style="padding: 7px;"><?=$alumno->carrera->descar?></TD> 
                </TR>
                 <TR style="border-bottom:solid;border-color:#CCC; border-width: 1px;">
                   <TD style="padding: 7px;">Psicólogo<?=($varios)?"s":""?> Tutor<?=($varios)?"es":""?> :</TD>
                    <TD style="padding: 7px;"><?php foreach($licenciados as $licenciado){
                        echo $licenciado."<br>";
                    } ?></TD> 
                </TR>
            </TABLE>
            </DIV>
        </TD>
       
    </TR>
    
</table>
</div>
<!-- hito 1  -->
<div class="subtitulo">II INDICADORES PSICOLÓGICOS DE RIESGO ACADÉMICO</div>
<div class="afiliacion">
    <?PHP ECHO $textolabel='El perfil psicológico de la evaluación inicial del alumno en riesgo académico en el semestre '.m::getCurrentPeriod().', presentó los siguientes indicadores psicológicos:' ;?>
</div>
<div class="afiliacion italica"  style="font-size:13px;color:#062142">
   <?php echo $model->metas; ?>  
</div>

<div class="subtitulo">III  DESARROLLO DE LOS INDICADORES PSICOLÓGICOS </div>
<?php  if($hay_subidos){  ?>
<div class="afiliacion">
    <b> Al término de la tutoría psicológica se describe (figura1) los indicadores psicológicos que se han logrado mejorar: </b>
</div>
<?php $detalles_subieron=$model->getDetalles()->andWhere(['tipo_cambio_real'=>'subio'])->all();    ?>
<?php foreach($detalles_subieron as $detalle) {?> 
  <div class="afiliacion">
   <?php  echo $detalle->actividades_realizadas;?>
   </div>
<?php } }  ?>

<?php  if($hay_iguales){  ?>
<div class="afiliacion">
    <b>Al término de la tutoría psicológica se describe (figura1) los indicadores psicológicos que se han mantenido:  </b>
</div>
<?php $detalles_iguales=$model->getDetalles()->andWhere(['tipo_cambio_real'=>'igual'])->all();    ?>
<?php foreach($detalles_iguales as $detalle) { ?> 
    <div class="afiliacion">
   <?php  echo $detalle->actividades_realizadas;?>
    </div>
<?php } } ?>


<?php  if($hay_bajados){  ?>
<div class="afiliacion">
  <b>Al término de la tutoría psicológica se describe (figura1) los indicadores psicológicos que requieren seguir reforzándose: </b>
</div>
<?php $detalles_bajados=$model->getDetalles()->andWhere(['tipo_cambio_real'=>'bajo'])->all();    ?>
<?php foreach($detalles_bajados as $detalle) { ?>   
 <div class="afiliacion">
 <?php    echo $detalle->actividades_realizadas; ?>
 </div>
<?php  } } ?>


<div class="afiliacion">
 <?php
   /*$expresion=new yii\db\Expression("100-percentil as complemento");  
    $datos=$query->select(['puntaje_total','percentil',$expresion,'categoria','b.nombre','b.nemonico','b.invertido'])->join('INNER JOIN','{{%sta_testindicadores}} b','indicador_id=b.id')->orderBy('b.ordenabs ASC')->asArray()->all();
   $indicadores= array_column($datos, 'nombre');
    $categorias= array_column($datos, 'categoria');
   $inversiones= array_column($datos, 'invertido');
    $percentiles= array_column($datos, 'percentil');
   $complemento= array_column($datos, 'complemento');
   $alabels=[];
   foreach($indicadores as $key=>$valor){
       $alabels[]=$valor.'-('.$categorias[$key].')';
       
       if($inversiones[$key]=='1'){
         $temppercentil=$percentiles[$key];
          $percentiles[$key]= $complemento[$key]; 
           $complemento[$key]= $temppercentil; 
       }
   }
    $percentiles=array_map('intval', $percentiles);
    $complemento= array_map('intval', $complemento);*/


 ?>
<diV id='migrafico' style="display:none;">
 <?php
 if($rutaimagen==''){     
   echo $this->render('/citas/reportes/makeGraficos',['model'=>$model,'tallerdet'=>$tallerdet])

 ?>
 <?php
  $string2="var chart = $('#grafiquito2').highcharts();
   
var opts = chart.options;        // retrieving current options of the chart
opts = $.extend(true, {}, opts); // making a copy of the options for further modification
delete opts.chart.renderTo;      // removing the possible circular reference

/* Here we can modify the options to make the printed chart appear */
/* different from the screen one                                   */

var strOpts = JSON.stringify(opts);
//alert(strOpts);
$.post(
    'https://export.highcharts.com/',
    {
        content: 'options',
        options: strOpts ,
         type:    'image/svg+xml',
        width:   '700px',
        scale:   '1',
        constr:  'Chart',
        async:   true
    },
    function(data){
    
        var imgUrl = 'https://export.highcharts.com/' + data;
        $('#miimagen').html('<img src=' +imgUrl+ '>');
        /* Here you can send the image url to your server  */
        /* to make a PDF of it.                            */
        /* The url should be valid for at least 30 seconds */
    }
);";

$this->registerJs($string2, \yii\web\View::POS_READY);  
 } 
    ?>
  </diV> 
   <?php  ?>
    <div id='miimagen' style="width: 700px;" >
        <div style="text-align: center" >figura 1</div>
       <?PHP //echo $rutaimagen;
       IF(strlen($rutaimagen)>0){
           echo Html::img($rutaimagen);
       } 
       ?>
    </div>
     
</diV>











<?php 
echo $this->render('@frontend/modules/sta/views/citas/reportes/makeGraficos',['model'=>$model,'tallerdet'=>$tallerdet])
?>div class


<div class="subtitulo">IV RECOMENDACIONES</div>
<div class="afiliacion">
    Se recomienda continuar con estrategias psicológicas para reforzar los siguientes indicadores que requieren mayor tiempo para su desarrollo:<br>
  <div class="afiliacion italica"  style="font-size:13px;color:#062142">
        <?PHP ECHO $model->recom_tutor_acad;  ?>
  </div>
</div>

<div>Atentamente: </div><br><br>
<div class="afiliacion" style="text-align:center; overflow:hidden;margin-top:3px;margin-bottom:3px;">
  <div style="float:left; width:50%; text-align: center;">
     <?php foreach($licenciados as $licenciado){
                        echo '<b>'. ucwords(mb_strtolower($licenciado,'UTF-8'))."<b><br>";
     } ?>
  </div> 
    
   <div style="float:left; width:50%;">
       <b>Dra. Elizabeth Dany Araujo Robles</b>
  </div>  
</div>
<div class="afiliacion" style="text-align:center; overflow:hidden;margin-top:3px;margin-bottom:3px;">
  <div style="float:left; width:50%;">
    Tutoría psicológica
  </div> 
   <div style="float:left; width:50%;">
    Coordinadora general de profesionales psicólogos
  </div>  
</div>
<div class="afiliacion" style="text-align:center; overflow:hidden;margin-top:3px;margin-bottom:3px;">
  <div style="float:left; width:50%; font-size:9px;">
    <?=$nombrefacultad ?>-UNI
  </div> 
   <div style="float:left; width:50%; font-size:9px;">
    TUTORÍA PSICOLÓGICA UNI
  </div>  
</div>




