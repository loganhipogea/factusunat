
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
