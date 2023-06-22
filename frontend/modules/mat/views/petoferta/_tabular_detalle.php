<?php  use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use common\widgets\prueba\pruebaWidget;
use common\helpers\ComboHelper;
use yii\widgets\Pjax;
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
            'title' => 'um',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
       'enableError' => true,
            'items'=> ComboHelper::getCboUms(true),
           'headerOptions' => [
                'style' => 'width: 10%',
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