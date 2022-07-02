<?php
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use unclead\multipleinput\examples\models\Item;
use unclead\multipleinput\TabularColumn;
use yii\widgets\Pjax;
use frontend\assets\NumberFormatAsset;
use common\widgets\inputajaxwidget\inputAjaxWidget;

/* @var $this \yii\web\View */
/* @var $models Item[] */
?>

<?php
NumberFormatAsset::register($this);
$form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'tabular-form',
    'options' => [
        'enctype' => 'multipart/form-data',
        
    ]
]) ?>

<?php Pjax::begin(['id'=>'monet']);  ?>
<?= TabularInput::widget([
    'models' => $models,
    'modelClass' => \frontend\modules\com\models\ComFactudet::class,
    'cloneButton' => false,
    'sortable' => false,
    'enableError'=>true,
    'min' => 0,
    'addButtonPosition' => [
        //TabularInput::POS_HEADER,
        TabularInput::POS_FOOTER,
        //TabularInput::POS_ROW
    ],
    'layoutConfig' => [
        'offsetClass'   => 'col-sm-offset-4',
        'labelClass'    => 'col-sm-2',
        'wrapperClass'  => 'col-sm-10',
        'errorClass'    => 'col-sm-4'
    ],
    'attributeOptions' => [
        'enableAjaxValidation'   => true,
        'enableClientValidation' => false,
        'validateOnChange'       => true,
        'validateOnSubmit'       => true,
        'validateOnBlur'         => false,
    ],
    'form' => $form,
    'columns' => [
        [
            'name' => 'id',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT
        ],
        [
            'name' => 'subtotal',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT
        ],
        [
            'name' => 'codart',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT
        ],
        
        [
            'name' => 'descripcion',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT
        ],
         [
            'name' => 'descripcion_fake',
            'type' => TabularColumn::TYPE_STATIC, 'title' => 'Código',
            
            'headerOptions' => [
                'style' => 'width: 60%',
                'class' => 'day-css-class'
            ]
         
        ],
        /*[
            'name' => 'codart',
            'title' => 'Código',
            'type' => TabularColumn::TYPE_TEXT_INPUT,
            'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
            ],
            'defaultValue' => 'Test',
            'enableError' => true
        ],*/
        [
            'name' => 'cant',
            'title' => 'Cant',
            'headerOptions' => [
                'style' => 'width: 40%',
                //'class' => 'day-css-class'
            ],
          'inputTemplate'=>'<div style="width:60px !important;font-weight:800; color:#90be49 !important; text-align:right !important; ">{input}</div>',
        ],
       [
            'name' => 'punitgravado',
            'title' => 'P. unit',
           'headerOptions' => [
               // 'style' => 'width: 40%',
                //'class' => 'day-css-class'
            ],
           'inputTemplate'=>'<div style="width:60px !important;font-weight:800; color:#90be49 !important; text-align:right !important; ">{input}</div>',
        ],
        
        [
            'name' => 'subtotal_raw',
            'title' => 'Subtot',
            'type' => TabularColumn::TYPE_STATIC,
            'columnOptions' => ['disabled'=>'disabled'],
            'inputTemplate'=>'<div style="font-weight:800; color:#90be49;text-align:right; ">{input}</div>',
        ],
        
        
    ],
]) ?>


<?php $this->registerJs(" $(document).on( 'change', 
    ' tr[class=\"multiple-input-list__item\"] input', function(){
             var_prefijo='comfactudet-';
             var_identidad=this.id;
             var_indice=var_identidad.substr(var_prefijo.length,1);
             var_cant=$('#comfactudet-'+var_indice+'-cant').val();
             var_punit=$('#comfactudet-'+var_indice+'-punitgravado').val();
             $('#comfactudet-'+var_indice+'-subtotal_raw').text(var_cant*var_punit,1)             
             $('#comfactudet-'+var_indice+'-subtotal').val(var_cant*var_punit)             
             
             //Numero de filas
           //n_filas = $('#monet').find('hidden[name*=\"subtotal\"]').length;
            //Recorriendo el bucle para halla el subtotal
                let vi = 0;
                var_subto=0;   
                  console.log('ENTERNASD AL BUCLE');
             $('#monet').find('input[name*=\"[subtotal]\"]').each(function(){
        	   
                        var_valor=$('#'+this.id).val();
                         if(var_valor===''){
                         var_valor=0;
                         }
                        var_subto= var_subto+parseFloat(var_valor);                       
                        console.log(this.id);
                        console.log(var_subto,1);
                       
        	});                 
            //Colocando el subtotal
            $('#total_a_pagar').val(var_subto,1);
            $('#id_pagado_compra').trigger('change');
        
       });", \yii\web\View::POS_READY);
  ?>

<?php $this->registerJs(" $(document).on('mouseup', 
    'div[class*=\"js-input-remove\"]', function(e){            
            var_index=$(this).parent().parent().attr('data-index');
          
           
            //Recorriendo el bucle para halla el subtotal
                let vi = 0;
                var_subto=0;    
             $('#monet').find('input[name*=\"[subtotal]\"]').each(function(){
        	         console.log('Var index');
                        console.log(var_index);
                        v_index_a_borrar=$('#'+this.id).parent().parent().attr('data-index');
                          console.log('Index a borrar');
                        console.log(v_index_a_borrar);
                      if(var_index===v_index_a_borrar){
                           console.log('Es la fila que borraste');
                        }else{
                            var_valor=$('#'+this.id).val();
                            if(var_valor===''){
                                var_valor=0;
                                }
                                    var_subto= var_subto+parseFloat(var_valor);                       
                                    console.log(this.id);
                                    console.log('eL SUBTOTAL');
                                    console.log(var_subto);
                        }                       
        	});                 
            //Colocando el subtotal
              $('#total_a_pagar').val(var_subto);
              $('#id_pagado_compra').trigger('change');
       });", \yii\web\View::POS_END);
  ?>
<?php Pjax::end();  ?>
<?php //= Html::submitButton('Update', ['class' => 'btn btn-success']); ?>
<?php ActiveForm::end(); ?>
<?php $this->registerJs("$(document).ready(function() {
       
      $('#btn_add_art').on('click',function(){
                   let vi = 0;

                    do {
                        vi = vi + 1;                        
                    } while ($('#select2-comfactudet-'+vi+'-codart-container').length);
                    vi=vi-1;
               var data = {
                    id: '100028',
                    text: 'Barn owl'
                        }; 
                  var newOption = new Option(data.text, data.id, true, false);
             // console.log(newOption);
           //alert('#comfactudet-'+vi+'-codart');
         $('#comfactudet-'+vi+'-codart').append(newOption).trigger('change'); 
         $('#select2-comfactudet-'+vi+'-codart-container').text(data.id+'-'+data.text); 
            //$('#comfactudet-'+vi+'-codart').val('100028');
           // alert($('#comfactudet-'+vi+'-codart').length);
         });
       });", \yii\web\View::POS_END);
  ?>
<div class="container">
  <div class="row float-right">
    <div class="col-xs-12 col-md-3 ">
      <div class="form-group ">
        <label for="">IGV</label>
        <div class="input-group">
          <input name="total_igv" id="id_total_igv" 
                 type="text" required class="form-control" 
                 disabled="disabled"
                 >
          
       </div>
      </div>      
    </div>
     <div class="col-xs-12 col-md-3 ">
        <div class="form-group ">
           <label for="">Subtotal</label>
            <div class="input-group">
                <input name="total_total" id="total_a_pagar" 
                 type="text" required class="form-control" 
                 disabled="disabled"
                 >
          
           </div>
          </div>
      </div>      
    </div>
    <!--   CUADROS DE PAGO Y VUELTO   -->
    
      
    <div class="row float-left">
         <!--   CUADRO DE MONTO PAGADO  -->
    <div class="col-xs-12 col-md-3 ">
      <div class="form-group ">
        <label for="">Pagado</label>
        <div class="input-group">
          <input name="total_igv" id="id_pagado_compra" 
                 type="text" required class="form-control" 
                
                 >
          
       </div>
      </div>      
    </div>
     <!--   CUADRO DE VUELTO  -->
     <div class="col-xs-12 col-md-3 ">
        <div class="form-group ">
           <label for="">Cambio</label>
            <div class="input-group">
                <input name="total_total" id="id_vuelto_compra" 
                 type="text" required class="form-control" 
                 disabled="disabled"
                 >
          
           </div>
          </div>
      </div>      
    </div>
  </div>
<?php $this->registerJs("$(document).ready(function() {       
      $('#id_pagado_compra').on('change',function(){
          var_vuelto=$('#id_pagado_compra').val()-parseFloat($('#total_a_pagar').val());
          console.log($('#id_pagado_compra').val());
          console.log(parseFloat($('#total_a_pagar').val()));
          if(var_vuelto<0){
            var_vuelto=0;
          }else{
          }
              $('#id_vuelto_compra').val(var_vuelto);  
         });
       });", \yii\web\View::POS_END);