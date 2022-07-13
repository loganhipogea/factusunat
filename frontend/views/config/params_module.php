<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
USE yii\widgets\Pjax;
?>
<h4><?=yii::t('base.names','Settings for module')?></h4>
<div class="form">
  <div class="box box-success">
     <?php Pjax::begin(['id'=>'pjax-valores']);  ?> 
    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-condensed table-hover table-bordered table-striped">
        <tr><th>Type</th><th>key</th><th>Value</th><th>Description</th></tr>
        <?php foreach($items as $i=>$item): ?>
            <tr>
                <td class="form-group"><?= $item->type ?></td>
                <td><?= $item->key ?></td>
                <td><?= $form->field($item,"[$i]value")->textArea(['id'=>'valor_'.$item->id])->label(''); ?></td>
                <td><?=$item->description?></td>
                <td><a id="<?=$item->id?>"  class="btn btn-sm  btn-danger " href="javaScript:void(0)" family="holas" rel="<?=Url::to(['/config/ajax-save-parameter','id'=>$item->id])?>"  id=enlace_"<?=$item->id?>"><i class="glyphicon glyphicon-refresh" ></i>Actualizar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?= Html::submitButton(yii::t('base.verbs','Save'),['class'=>'btn btn-danger']); ?>
    <?php ActiveForm::end(); ?>
    <?php 
    
    
     $cadenaJs="$('div[id=\"pjax-valores\"] [family=\"holas\"]').on( 'click', function() { 
       ;
     var yapaso=false;
     if(this.rel===''){
       var_url=this.title;
     }else{
       var_url=this.rel;
     }
     v_valor=$('#valor_'+this.id).val();
     v_descripcion=$('#descripcion_'+this.id).val();
    if(!yapaso){  
            $.ajax({
              url: var_url,
              
              type: 'POST',
              data: {valor:v_valor,descripcion:v_descripcion}   ,
              dataType: 'json',
               error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              
              success: function(json) {
             
              
                        var n = Noty('id');
                          
                           $.pjax.reload({container: '#pjax-valores', async: false});
                           
                          
                             

                       if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error');  
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             } 
                            
                            }
                                        
                        });  
                      yapaso=true; 
                     }      
                        })";
       
  // echo  \yii\helpers\Html::script($stringJs);
   $this->registerJs($cadenaJs, \yii\web\View::POS_END);
    ?>
</div><!-- form -->
</div>
