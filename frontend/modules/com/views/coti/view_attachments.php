<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>


 

    

        <?php if($model->hasAttachments()) { 
       //echo $model::className();die();
       //echo $model->files[0]->urlTempWeb ;
       echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => '100%',
                            'height' =>'100%',
            ]); ?> 
         <?php } else{?>
         <p class="text-aqua">Este documento no tiene adjuntos</p>
         <?php }?>
  
    
       <?php 
         foreach($model->envios as $envio){
             
         }
       ?>
    
   
  


