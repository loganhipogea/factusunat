<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use yii\helpers\Url;

use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
   
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-form">
     <div class="box-body">
      <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
          
            
           ?>
           <?php
           echo Html::button("Agregar",['onclick'=>"saves_widget()", 'class' => 'btn btn-success']);
           ?>
           </div>
        </div>
    </div>
     
  
      <div class="box-body">
         
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codean')->textInput(['maxlength' => true]) ?>
</div>
   
   
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    
    <?= $form->field($model, 'codum')->
            dropDownList(ComboHelper::getCboUms() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>($model->isBlockedField('codtipo'))?'disabled':null,
                        ]
                    ) ?>
       
</div>    
    
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codtipo')->
            dropDownList(ComboHelper::getTablesValues('maestrocompo.codtipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    </div>
      </div>
    <?php ActiveForm::end(); ?>
     
    <?php  
    $url=Url::to(['/com/com/create-material']); 
   $cadenaJs="function saves_widget(){
        var \$formulario=$('#myformulario');       
        $.ajax({
            url:'".$url."',
            type: 'post',
            data:\$formulario.serialize(),
            success: function(data){
          
               if(data.success=='1') {
                   if(data.type==1) {
                       $('#".$idModal."').modal('hide'); 
                          
                        







                         $('div[class*=\"js-input-plus\"]').trigger('click');   
                           v_maximo=0;
                                  $('#monet').find('input[name*=\"[subtotal]\"]').each(function(){
                                                            var_index=$(this).parent().parent().attr('data-index'); 
                                                                    if(v_maximo < var_index ){
                                                                    v_maximo=var_index
                                                                    } //fin de if
                                                     
                                 });//fin del each          
                              $('#comfactudet-'+v_maximo+'-'+'descripcion_fake').text('descripcon aqui');
                                 $('#comfactudet-'+v_maximo+'-'+'cant').val(1);
                                 $('#comfactudet-'+v_maximo+'-'+'punitgravado').val(0);
                                 $('#comfactudet-'+v_maximo+'-'+'punitgravado').trigger('change');
                                 $('#comfactudet-'+v_maximo+'-'+'codart').val('codigo aqui');
                                 $('#comfactudet-'+v_maximo+'-'+'descripcion').val('descripcion otra vez qui');
                           















                        
                    }else{
                          $('#".$idModal."').modal('hide');
                              
                          
                         $('div[class*=\"js-input-plus\"]').trigger('click');   
                           v_maximo=0;
                                  $('#monet').find('input[name*=\"[subtotal]\"]').each(function(){
                                                            var_index=$(this).parent().parent().attr('data-index'); 
                                                                    if(v_maximo < var_index ){
                                                                    v_maximo=var_index
                                                                    } //fin de if
                                                     
                                 });//fin del each    
                                 console.log(data.campos.codart);
                              $('#comfactudet-'+v_maximo+'-'+'descripcion_fake').text(data.campos.codart+'-'+data.campos.descripcion);
                                 $('#comfactudet-'+v_maximo+'-'+'cant').val(1);
                                 $('#comfactudet-'+v_maximo+'-'+'punitgravado').val(0);
                                 $('#comfactudet-'+v_maximo+'-'+'punitgravado').trigger('change');
                                 $('#comfactudet-'+v_maximo+'-'+'codart').val(data.campos.codart);
                                 $('#comfactudet-'+v_maximo+'-'+'descripcion').val(data.campos.descripcion);
                           


                               
                     }
               }
               if(data.success=='3'){
                      var msg=data.msg;
                      var n = Noty('id');
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ msg);
                        $.noty.setType(n.options.id, 'error'); 
                    }
               if(data.success=='2') {
                   var msg=data.msg;
                   if(msg){
                       $.each(msg,function(key,val){
                           var div=$('.field-'+key);
                           div.addClass(' has-error');
                           div.find('.help-block').html(val);
                       });
                   }
               }
            }
              });
    }";
   $this->registerJs($cadenaJs, \yii\web\View::POS_HEAD);


    ?>
</div>
    </div>
</div>
