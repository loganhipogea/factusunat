<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\h;
use yii\widgets\Pjax;
use yii\grid\GridView; 
use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use frontend\modules\cc\models\CcGastos;
     ?> 
<div class="box-body">
<div>
        <?php if($model->hasAttachments()) { 
       //echo $model::className();die();
       //echo $model->files[0]->urlTempWeb ;
       echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => 700,
                            'height' => 900,
            ]); ?> 
         <?php } ?>
    </div>
    
   
  
  </div>