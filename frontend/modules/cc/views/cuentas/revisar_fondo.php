<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\helpers\FileHelper;
use common\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;
//use common\helpers\FileHelper;
use dosamigos\chartjs\ChartJs;
 use kartik\date\DatePicker;
use frontend\modules\cc\models\CcGastos;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>


     <div class="box-body">
         <div>
      <?php 
        $avance=$model->porcentajeAvance();
         $bloqueado=true; 
      $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                     
                   
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">    
                        <?= $form->field($model, 'numero')->textInput(['disabled'=>true]) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">   
                             <?= $form->field($model, 'fecha')->textInput(['disabled'=>true]) ?>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">   
                            <?= $form->field($model, 'fvencimiento')->textInput(['disabled'=>true]) ?>
                     </div>
                 
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'descripcion')->textInput(['value'=>$model->trabajador->fullName(),'disabled'=>true,])->label(yii::t('base.names','Imputado')) ?>
                    </div>  
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'descripcion')->textInput(['disabled'=>true,]) ?>
                    </div> 
                 
                 
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                             
                            <?= $form->field($model, 'monto')->textInput(['disabled'=>true,]) ?>
                           
                   </div> 
                     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
                             
                            <?= $form->field($model, 'monto_rendido')->textInput(['disabled'=>true,]) ?>
                           
                   </div> 
                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
                             
                            <?= $form->field($model, 'codmon')->textInput(['disabled'=>true,]) ?>
                           
                   </div> 
                          
                   
                  
                  
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'detalle')->textArea(['disabled'=>true,]) ?>
                        </div>
                    <?php ActiveForm::end(); ?>   
            </div>          
        </div>
       
    <?php 
    $avanceCali=$model->porcentajeAvanceCalificacion();
    ?>
         <div id="relleno">
             <?php echo $this->render(
                     'revisar_fondo_detalle',
                     [
                        'model'=>$model,
                        'comprobante'=>$model->firstComprobante()
                     ]
                     );   
             ?> 
         </div>
   </div> 
             
      
           
         
     