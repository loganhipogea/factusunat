<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php 
    
     echo $this->render('_comprobante_calificacion',['model'=>$model]);
    ?>
    
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php if($model->hasAttachments()) { 
      echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => 500,
                            'height' => 900,
            ]); ?> 
         <?php } ?>
    
</div>