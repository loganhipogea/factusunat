<?php  use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use common\widgets\selectwidget\selectWidget;
use common\helpers\ComboHelper;
use common\widgets\prueba\pruebaWidget;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div id="colector_tabular">
 <?php  
 $lista=$items[0]->dataComboValores('estadomaterial');
 ?>
<?= TabularInput::widget([
    'models' => $items,
    
     'cloneButton' => false,
    'sortable' => true,
    'enableError'=>true,
    'min' => 0,
    'addButtonPosition' => [
        //TabularInput::POS_HEADER,
        TabularInput::POS_FOOTER,
        //TabularInput::POS_ROW
    ],
    'attributeOptions' => [
       'enableAjaxValidation'      => true,
        'enableClientValidation'    => true,
        'validateOnChange'          => true,
        'validateOnSubmit'          => true,
        'validateOnBlur'            => false,
    ],
    'columns' => [
        [
            'name'  => 'id',
            'title' => 'id',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
       'enableError' => true,
            ],
        [
            'name'  => 'item',
            'title' => 'item',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
             'headerOptions' => [
                'style' => 'width: 5%',
                //'class' => 'day-css-class'
            ],
       'enableError' => true,
            ],
        [
            'name'  => 'codum',
            'title' => 'codum',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
       'enableError' => true,
            'items'=> ComboHelper::getCboUms(true),
           'headerOptions' => [
                'style' => 'width: 7%',
                //'class' => 'day-css-class'
                       ],
          ],
        
         [
            'name'  => 'cant',
            'title' => 'cant',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
       'enableError' => true,
          'headerOptions' => [
                'style' => 'width: 10%',
                //'class' => 'day-css-class'
            ],  
            
            ],
        
         ['name'  => 'codart',
            'title' => 'CODIGO',
         'type'  =>pruebaWidget::className(),/*kartik\date\DatePicker::className(),*//*pruebaWidget::className(),*/
    //'type'  =>kartik\select2\Select2::className(),
            'options'=>[
            'tabular'=>true,
           // 'id'=>'mipapa',
          // 'model'=>$data,
            'form'=>$form,
            //'campo'=>'codart',
            'ordenCampo'=>2,
            //'foreignskeys'=>[1,3],
                              ],
             'headerOptions' => [
                'style' => 'width: 20%',
                //'class' => 'day-css-class'
            ],
           /* 'options'=>[
             'id'=> uniqid(),
           // 'tabular'=>true,
           // 'id'=>'mipapa',
            'model'=>$items[0],
            'form'=>$form,
            'attribute'=>'codigo',
            'campo'=>'codigo',
            'ordenCampo'=>5,
             'inputOptions'=>['labelOptions'=>['label'=>false]],
            //'foreignskeys'=>[1,2,3],
                              ],*/
        'enableError' => true,
            ],
     
        [
            'name'  => 'descripcion',
            'title' => 'Descripcion',
             
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
       'enableError' => true,
            'headerOptions' => [
                'style' => 'width: 40%',
                //'class' => 'day-css-class'
            ],
            //'items'=> ComboHelper::getCboUms(),
            ],
        
            /*['name'  => 'codart',
            'title' => 'codart',
            //'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT, 
            'type'  =>selectWidget::className(),
        'options'=>[
            'tabular'=>true,
          'form'=>$form,
            'campo'=>'codart',
            'ordenCampo'=>2,
            
                              ],
        'enableError' => true,
            ],*/
        
        [
            'name'  => 'estadomaterial',
            'title' => 'Estado',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
       'enableError' => true,
            'items'=> $lista,
           'headerOptions' => [
                'style' => 'width:15%',
                //'class' => 'day-css-class'
                       ],
          ],
    ],
]) ?>
</div>

  <?php  
     $this->registerJs("$('#matvale-codmov').on( 'change', function() { 
        var resulta;
        var identi=this.id;  
        var urli='".\yii\helpers\Url::to(['mat/ajax-verif-transa'])."';
        var cod=$('#matvale-codmov').val();
        var promesa1= $.ajax({
           url : urli,
          type : 'GET', 
          data : {codtrans:cod}, 
          dataType: 'json', 
          success : function(json) {
                            resulta1=json['success'];
                                                  
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        }).then(function(){ 
            if(resulta1['afecta_precio']=='0'){
                      $('#colector_tabular').find('input[name$=\"][punit]\"]').each(function(){
        	         $('#'+this.id).hide();
                       });  
            } else{
                $('#colector_tabular').find('input[name$=\"][punit]\"]').each(function(){
        	        $('#'+this.id).show();
                       
                        });  
            }
            
           

       });
    
});

", \yii\web\View::POS_READY);
    ?>  



  <?php  
     $this->registerJs("$('[name$=\"][codart]\"]').on( 'change', function() { 
       var_idselect=this.id;
       var_indice=var_idselect.substring(9,10);
         var urli='".\yii\helpers\Url::to(['/masters/materials/ajax-html-ums'])."';
      var_codigo=this.value;
     
        var promesa1= $.ajax({
           url : urli,
          type : 'POST', 
          data : {valorInput:this.value}, 
          dataType: 'html', 
         error:function(xhr, status, error){ 
                            var n = Noty('id');                      
                             $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ xhr.responseText);
                              $.noty.setType(n.options.id, 'error');         
                                }, 
            success: function (data) {
               $('#matdetne-'+var_indice+'-codum').html(data);
                }
       }).then(function(){ 
       
              $.ajax({
           url : '".\yii\helpers\Url::to(['/masters/materials/ajax-descri-mat'])."',
          type : 'POST', 
          data : {codart:var_codigo}, 
          dataType: 'json', 
         error:function(xhr, status, error){ 
                            var n = Noty('id');                      
                             $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ xhr.responseText);
                              $.noty.setType(n.options.id, 'error');         
                                }, 
            success: function (data) {
             
               $('#matdetne-'+var_indice+'-descripcion').val(data['success']);
                }
       });

       });
    
});

", \yii\web\View::POS_READY);
    ?>  
