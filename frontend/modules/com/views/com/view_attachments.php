<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="com-ov-view">

 

    
<div class="box-body">
     <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
        <?php if($model->hasAttachments()) { 
       //echo $model::className();die();
       //echo $model->files[0]->urlTempWeb ;
       echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => 300,
                            'height' => 400,
            ]); ?> 
         <?php } else{?>
         <p class="text-aqua">Este documento no tiene reporte generado aun</p>
         <?php }?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
         <?php if($model->hasSends()) { ?>
         <?php $envio=$model->lastSend();?>
        <h4>ULTIMO ENVIO: <?=$envio->comboValueText('tipo');?></h4>
         <?php if(!empty($model->urlCdr()) &&!empty($model->urlXml()) ) { ?>
        <table class="table">
        <tbody>
          <thead>
              
              <th>ARCHIVOS DE RESPUESTA</th>
          </thead>
            <tr>
                <td><?php
                if(!empty($model->urlCdr()))
                echo Html::a('<span class=" btn btn-danger"><i class="glyphicon glyphicon-compressed"></i>'.yii::t('base.verbs','Download').'.zip</span>', $model->urlCdr(), ['data-pjax'=>'0']);  ?>
                </td>
                
            </tr>
            <tr>
                
                <td><?php 
                if(!empty($model->urlXml()))
                echo Html::a('<span class=" btn btn-danger"><i class="glyphicon glyphicon-console"></i>'.yii::t('base.verbs','Download').'.xml</span>', $model->urlXml(), ['data-pjax'=>'0']);  ?>
                </td>
            </tr>
            
        </tbody>
    </table>
        <?php } else{  ?>
        <p class="text-aqua">El último envío <?=$envio->cuando?> a SUNAT registra errores:</p>
            <table>
                <thead>
                <th>Código</th><th>Error</th>
                </thead>
         <?php     
           $errores=$envio->mensaje ;
            foreach($errores as $code=>$mensaje){ ?>
                <tr>
                    <td><?=$code?></td>
                    <td><?=$mensaje?></td>
                </TR>
           <?php }
          ?> 
          </table>
        <?php } ?>
        <?php } else{ ?>
        <p class="text-aqua">Este documento no registra envíos a la SUNAT </p>
        <?php } ?>
    </div>
   
  
  </div>
</div>
