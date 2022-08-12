<?php
use yii\helpers\Html;
use yii\helpers\Url;
$url=Url::to(['']);
?>

<div style="margin:3px; padding:15px; border-style: solid; border-width: 1px; border-color: #ccc;" >
    
        
           <div class="pull-left">
                <?=Html::a($model->titulo,$model->url,['data-pjax'=>'0'])?>
           
            </div>
            <div class="pull-right">
                <?=Html::a('<span class="fa fa-user"></span>',$url,['class'=>'btn btn-sm btn-primary botonAbre'])?>
            </div>
        
        
            
    
    
    <div style=" height: 350px; display: flex;
    flex-direction: column;padding:5px;text-align: justify;
    justify-content: space-evenly; background-color: #efefef;margin-top:35px;border-style:solid;border-color: #ccc; border-width: 1px; border-bottom:0px;border-left:0px;border-right:0px;" >
        <?=substr($model->detalle,0,200)?> 
        <?php if($model->isImage()){  ?>
          <?= Html::img($model->url,['width'=>"100%",'height'=>"100%"])?>
        <?php } elseif($model->isPdf()){?>
          <?php echo $this->render('@frontend/views/comunes/view_pdf',['urlFile'=>$model->urlTempWeb,'width'=>200,'height'=>200]) ?>    
         <?php }else{ ?>
             
         <?php } ?>
    </div>
    </div>

