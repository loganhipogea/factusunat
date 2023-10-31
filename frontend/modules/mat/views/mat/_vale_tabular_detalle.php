<?php  use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use common\widgets\prueba\pruebaWidget;
use common\helpers\ComboHelper;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

$modelReq= frontend\modules\mat\models\MatReq::instance();
$codocuReq=$modelReq->codocu();
?>
<div id="colector_tabular">
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
                'style' => 'width: 10%',
                //'class' => 'day-css-class'
            ],
       'enableError' => true,
            ],
        [
            'name'  => 'um',
            'title' => 'um',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
       'enableError' => true,
            'items'=> ComboHelper::getCboUms(true),
           'headerOptions' => [
                'style' => 'width: 15%',
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
            //'campo'=>'codigo',
            'ordenCampo'=>2,
            //'foreignskeys'=>[1,3],
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
            'name'  => 'punit',
            'title' => 'punit',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
       'enableError' => true,
            'headerOptions' => [
                'style' => 'width: 20%',
                //'class' => 'day-css-class'
            ],
            //'items'=> ComboHelper::getCboUms(),
            ],
         [
            'name'  => 'detres_id',
            //'title' => 'punit',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
       
            ],
        [
            'name'  => 'detreq_id',
            //'title' => 'punit',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
       
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
        
        
    ],
]) ?>
</div>

  <?php  
     $this->registerJs("$('#matvale-codmov').one( 'change', function() { 
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
     $this->registerJs("$('[name$=\"][codart]\"]').one( 'change', function() { 
       var_idselect=this.id;
       var_indice=var_idselect.substring(11,12);
         var urli='".\yii\helpers\Url::to(['/masters/materials/ajax-html-ums'])."';
      
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
               $('#matdetvale-'+var_indice+'-um').html(data);
                }
       });
    
});

", \yii\web\View::POS_READY);
    ?>  



 <?php  
     
     $this->registerJs("$('#matvale-numerodoc').on('change', function() { 
        var urli='".\yii\helpers\Url::to(['mat/ajax-verifica-req'])."';
        var var_cod='".$codocuReq."';
        var var_codocu=$('#matvale-codocu').val();
        
        if(var_cod==var_codocu){//Si se trata de una requisicion
            var_numreq=$('#matvale-numerodoc').val();

            alert( var_numreq);
          var promesa1= $.ajax({
          url : urli,
          type : 'POST', 
          data : {numeroreq:var_numreq}, 
          dataType: 'json', 
          success : function(json) {
                             
                            resulta1=json['success'];
                                               
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        }).then(function(){ 
            
            if(resulta1>0){//Se trata de una requisicion
            $('#matdetvale-0-codart').select2('data', { id:'100568', text: 'HOLA-100568'});
        
                     $('div[class*=\"js-input-plus\"]').trigger('click');
            }else{
                alert('naa'); 
                      
            }
       });




        }//Fin de if(var_cod==var_codocu)
        
    
});

", \yii\web\View::POS_READY);
    ?>  