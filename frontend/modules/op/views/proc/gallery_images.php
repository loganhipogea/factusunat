<?php
use common\widgets\imagewidget\ImageWidget;

 foreach ($model->getImages() as $rowImage){
    echo  ImageWidget::widget([
         'ancho '=>100,'alto'=>100
     ]);
 }

?>

