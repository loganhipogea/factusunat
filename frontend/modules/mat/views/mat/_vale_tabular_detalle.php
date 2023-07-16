<?php  use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use common\widgets\prueba\pruebaWidget;
use common\helpers\ComboHelper;
use yii\widgets\Pjax;
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