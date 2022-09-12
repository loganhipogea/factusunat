<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\helpers\FileHelper;
use yii\widgets\DetailView;
use common\models\masters\Clipro;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use kartik\editable\Editable;

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
        <div class="pull-left"> 
            <?php 
            //$url=Url::to(['cc/cuentas/revisar-fondo','id'=>$comprobante->previousId()]);
            echo Html::button('<i style="color:#90be49;font-size:3em;"> <span class="glyphicon glyphicon-chevron-left"></span></i>',['id'=>'btn_siguiente' ,'class'=>'btn']);
            ?>
           </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
        <div class="pull-right"> 
           <?php 
            //$url=Url::to(['cc/cuentas/revisar-fondo','id'=>$comprobante->nextId()]);
           echo Html::button('<i style="color:#90be49;font-size:3em;"> <span class="glyphicon glyphicon-chevron-right"></span></i>',['id'=>'btn_atras', 'class'=>'btn']);
             ?>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
        <div class="form-group no-margin">
            <div class="btn-group">
    <?php  
     $pjax_zona_botones='pjax-bootnes';
      Pjax::begin(['id'=>$pjax_zona_botones]);
      if($comprobante->isCreated()){
          /*Boton  observar*/
            /*Boton aprobación*/
           $url= Url::to(['/cc/cuentas/modal-crea-obs','id'=>$comprobante->id,'gridName'=>'pjax-obs','idModal'=>'buscarvalor']);
            echo  Html::button(yii::t('base.names','<span class="fa fa-close"></span>Observar'), ['href' => $url, 'title' => yii::t('base.names','Observación'),'id'=>'btn_observacion', 'class' => 'botonAbre btn btn-danger']); 
            
             echo  Html::button(yii::t('base.names','<span class="fa fa-check"></span>Aprobar'), [ 'title' => yii::t('base.names','Observación'),'id'=>'btn_aprobacion', 'class' => 'btn btn-success']); 
            
       }elseif($comprobante->isObserved()){
           /*Boton deshacer observacion*/
            // $url= Url::to(['/cc/cuentas/ajax-unobserved','id'=>$comprobante->id,'revert'=>'yes','gridName'=>'pjax-obs','idModal'=>'buscarvalor']);
            echo  Html::button(yii::t('base.names','<span class="fa fa-history"></span>Quitar obs'), [ 'title' => yii::t('base.names','Observación'),'id'=>'btn_unobserved', 'class' => 'btn btn-success']); 
            
       }elseif($comprobante->isPassed()){
           /*Boton deshacer aprobación*/ 
             //$url= Url::to(['/cc/cuentas/ajax-unaprobed','id'=>$comprobante->id,'revert'=>'yes','gridName'=>'pjax-obs','idModal'=>'buscarvalor']);
            echo  Html::button(yii::t('base.names','<span class="fa fa-user"></span>Quitar aprobac'), [ 'title' => yii::t('base.names','Observación'),'id'=>'btn_unaprobed', 'class' => 'btn btn-success']); 
          
       }
       
      
        $url= Url::to(['/cc/cuentas/ajax-aprobe','id'=>$comprobante->id]);           
        echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_aprobacion',
     'isDivReceptor'=>true,
            //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>$url,
            'id_input'=>'btn_aprobacion',
            'idGrilla'=>$pjax_zona_botones
      ])  ?>  
<?php
        $url= Url::to(['/cc/cuentas/ajax-aprobe','id'=>$comprobante->id,'revert'=>'yes']);           
        echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_unaprobed',
     'isDivReceptor'=>true,
            'otherContainers'=>['pjax-obs'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>$url,
            'id_input'=>'btn_unaprobed',
            'idGrilla'=>$pjax_zona_botones
      ])  ?>  

<?php
        $url= Url::to(['/cc/cuentas/ajax-unobserved','id'=>$comprobante->id,'revert'=>'yes']);           
        echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_unobserved',
     'isDivReceptor'=>true,
            //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>$url,
            'id_input'=>'btn_unobserved',
            'idGrilla'=>$pjax_zona_botones
      ]);
                
     Pjax::end();           
                ?> 
  
    
            </div>
       </div>

    <?php
       $formato=h::formato();
        echo DetailView::widget([
        'model' =>$comprobante,
        'attributes' => [
            [                      // the owner name of the model
            'label' => Yii::t('base.names','Documento'),
               'value' => $comprobante->documento->desdocu,
            ],
            [                      // the owner name of the model
              'label' => Yii::t('base.names','Número'),
              'format'=>'raw',
              'value' => $comprobante->serie.'-'.$comprobante->numero.$comprobante->buttonSatus(20),
            ],
            [                      // the owner name of the model
            'label' => Yii::t('base.names','Monto'),
              'value' => $formato->asDecimal($comprobante->monto,2).'  -   '.$comprobante->codmon,
            ],
           [                      // the owner name of the model
            'label' => Yii::t('base.names','RUC'),
              'value' => $comprobante->rucpro,
            ],
            [                      // the owner name of the model
            'label' => Yii::t('base.names','RUC'),
              'value' => Clipro::findOne(['rucpro'=>$comprobante->rucpro])->despro, 
            ],
            
                      
        ],
    ]);
//$form= ActiveForm::begin(['method'=>'post']);

          Pjax::begin(['id'=>'pjax-obs']);
        echo Html::textInput('obser', $comprobante->obs,['class'=>'form-control','disabled'=>true]);
            Pjax::end(); 
        
   echo inputAjaxWidget::widget([
            'isHtml'=>true,
             'id'=>'btn_siguiente',
     'isDivReceptor'=>true,
            //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/cc/cuentas/ajax-render-compro','id'=>$comprobante->nextId()]),
            'id_input'=>'btn_siguiente',
            'idGrilla'=>'relleno'
      ])  ?>  
<?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
             'id'=>'btn_atras',
            'isDivReceptor'=>true,
            //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/cc/cuentas/ajax-render-compro','id'=>$comprobante->previousId()]),
            'id_input'=>'btn_atras',
            'idGrilla'=>'relleno'
      ])  ?>  


</div>  
<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12"> 
  <?php if($comprobante->hasAttachments()) { 
       //echo $model::className();die();
       //echo $model->files[0]->urlTempWeb ;
       echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $comprobante->files[0]->urlTempWeb,
                         'width' => '100%',
                            'height' => 400,
            ]); ?> 
         <?php } ?>
</div>  

