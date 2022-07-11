<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\ComboHelper;
use common\models\masters\Tipocambio;
use common\helpers\h;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-form">
 
    
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <label class="control-label" for="buscador_id">Explorar</label>
          <input  type="text" id="buscador_id" class="form-control">
      </div>
      <div id="zona_stock" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          
      </div>
       <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
            'isHtml'=>true,//Devuelve datos Html
            'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST',            
            'evento'=>'keypress',
            'ruta'=>Url::to(['/com/com/ajax-show-stock']),
            'id_input'=>'buscador_id',
            'idGrilla'=>'zona_stock'
      ])  ?>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php $form = ActiveForm::begin([
        'id'=>'Form_general',
        'enableAjaxValidation'=>true
        ]); ?>  
        <div class="form-group">
        <?= Html::submitButton('<span class="fa fa-save"></span>- -'.Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
        <?php 
        $url= Url::to(['/com/com/create-material','gridName'=>'non3e','idModal'=>'buscarvalor']);
             echo  Html::button('<span class="fa fa-user"></span>'.yii::t('base.verbs','Crear material'), ['href' => $url, 'title' => 'Nuevo material ','id'=>'btn_contacts','gridName'=>'sa',    'class' => 'botonAbre btn btn-success']); 
         ?>
        
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
             <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <?= $form->field($model, 'sunat_tipodoc')->
            dropDownList([
                h::sunat()->graw('s.01.tdoc')->g('FACTURA')=>yii::t('base.names','Invoice'),
                h::sunat()->graw('s.01.tdoc')->g('BOLETA')=>yii::t('base.names','Voucher')
                ],
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
       <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'codmon')->
            dropDownList([Tipocambio::COD_MONEDA_DOLAR=>Tipocambio::COD_MONEDA_DOLAR,
                Tipocambio::COD_MONEDA_BASE=>Tipocambio::COD_MONEDA_BASE] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
        <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> -->
            <?PHP  /*echo $form->field($model, 'codsoc')->
            dropDownList(['A'=>'SOCIEDAD','B'=>'SOCIEDAD2'] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    )*/ ?>

         <!--</div>-->
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'sunat_tipdoccli')->
            dropDownList(h::sunat()->graw('s.06.tdociden')->combo()->data ,
                    [
                        //'prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tipopago')->
            dropDownList(ComboHelper::getTablesValues('com_ov.tipopago') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
   
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'rucpro')->textInput(['maxlength' => true]) ?>
        </div>
   
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
         <?= $form->field($model, 'nombre_cliente')->textInput(['maxlength' => true]) ?>
         
         
         
           <?php 
            
           /*= $form->field($model, 'despro')->textInput([
               'id'=>'zona_pk',
               'disabled'=>true,
               //'value'=>(empty($model->rucodni))?'':$model->clipro->despro,
               'maxlength' => true])*/ ?>   
         
         

        </div>
       
        
      
            <?php   
            echo $this->render('orden_venta_tabular_plus.php', ['models' => $models]);
            ?>
            <?php ActiveForm::end(); ?>
            <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'comfactura-rucpro',
            'idGrilla'=>'comfactura-nombre_cliente'
            ])  ?>
   </div> 
</div>
 <?php $ruc=h::sunat()->graw('s.06.tdociden')->g('RUC');
       $dni=h::sunat()->graw('s.06.tdociden')->g('DNI');
       h::sunat()->clearCache();
        $cadenaJs="$('#comfactura-sunat_tipodoc').on( 'change', function() {
                   if($('#comfactura-sunat_tipodoc').val()=='".$model::TYPE_DOC_INVOICE."'){
                        $(\"#comfactura-sunat_tipdoccli  option[value='".$ruc."']\").attr('selected', true);                       
                       //$('#comfactura-sunat_tipdoccli').attr('disabled', 'disabled');
                         }else{
                           $('#comfactura-sunat_tipdoccli').removeAttr('disabled');
                           $(\"#comfactura-sunat_tipdoccli  option[value='".$dni."']\").attr('selected', true);
                       
                        }
                        });
                    ";
  // echo  \yii\helpers\Html::script($stringJs);
   $this->registerJs($cadenaJs, \yii\web\View::POS_END);        
        ?>
