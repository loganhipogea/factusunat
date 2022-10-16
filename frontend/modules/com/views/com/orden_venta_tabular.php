<?php
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use unclead\multipleinput\examples\models\Item;
use unclead\multipleinput\TabularColumn;
use yii\widgets\Pjax;
use frontend\assets\NumberFormatAsset;
use common\widgets\selectwidget\selectWidget;
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
    'modelClass' => \frontend\modules\com\models\ComOvdet::class,
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
    
    'columns' => [
        [
            'name' => 'id',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT
        ],
        [
            'name' => 'subtotal',
            'type' => TabularColumn::TYPE_HIDDEN_INPUT
        ],
        
         ['name'  => 'codart',
            'title' => 'CODIGO',
            'type'  =>selectWidget::className(),
        'options'=>[
            'tabular'=>true,
           // 'id'=>'mipapa',
          // 'model'=>$data,
            'form'=>$form,
            'campo'=>'codart',
            'ordenCampo'=>1,
            //'foreignskeys'=>[1,2,3],
                              ],
        'enableError' => true,
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
            ]
        ],
       [
            'name' => 'pventa',
            'title' => 'P. venta',
           'headerOptions' => [
                'style' => 'width: 40%',
                //'class' => 'day-css-class'
            ],
           'inputTemplate'=>'<div style="font-weight:800; color:#90be49 !important; text-align:right !important; ">{input}</div>',
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
             var_prefijo='comovdet-';
             var_identidad=this.id;
             var_indice=var_identidad.substr(var_prefijo.length,1);
             var_cant=$('#comovdet-'+var_indice+'-cant').val();
             var_punit=$('#comovdet-'+var_indice+'-pventa').val();
             $('#comovdet-'+var_indice+'-subtotal_raw').text($.number(var_cant*var_punit,1))             
             $('#comovdet-'+var_indice+'-subtotal').val(var_cant*var_punit)             
             
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
                        console.log($.number(var_subto,1));
                       
        	});                 
            //Colocando el subtotal
            $('#total_a_pagar').val($.number(var_subto,1));
        
       });", \yii\web\View::POS_READY);
  ?>

<?php $this->registerJs(" $(document).on('mouseup', 
    'div[class*=\"js-input-remove\"]', function(e){            
            var_index=$(this).parent().parent().attr('data-index'); 
            //Recorriendo el bucle para halla el subtotal
                let vi = 0;
                var_subto=0;    
             $('#monet').find('p[class=\"form-control-static\"]').each(function(){
        	     
                        console.log(var_index);
                        console.log($('#'+this.id).parent().parent().parent().attr('data-index'));
                      if(var_index===$('#'+this.id).parent().parent().parent().attr('data-index')){
                           console.log('Es la fila que borraste');
                        }else{
                            var_valor=$('#'+this.id).text();
                            if(var_valor===''){
                                var_valor=0;
                                }
                                    var_subto= var_subto+parseFloat(var_valor);                       
                                    console.log(this.id);
                                    console.log(var_subto);
                        }                       
        	});                 
            //Colocando el subtotal
              $('#total_a_pagar').val(var_subto);
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
                    } while ($('#select2-comovdet-'+vi+'-codart-container').length);
                    vi=vi-1;
               var data = {
                    id: '100028',
                    text: 'Barn owl'
                        }; 
                  var newOption = new Option(data.text, data.id, true, false);
             // console.log(newOption);
           //alert('#comovdet-'+vi+'-codart');
         $('#comovdet-'+vi+'-codart').append(newOption).trigger('change'); 
         $('#select2-comovdet-'+vi+'-codart-container').text(data.id+'-'+data.text); 
            //$('#comovdet-'+vi+'-codart').val('100028');
           // alert($('#comovdet-'+vi+'-codart').length);
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
  </div>
</div>