<?php  use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use common\widgets\selectwidget\selectWidget;
use common\helpers\ComboHelper;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id'=>'monet']);  ?>
<?= TabularInput::widget([
    'models' => $items,
    'attributeOptions' => [
       'enableAjaxValidation'      => true,
        'enableClientValidation'    => false,
        'validateOnChange'          => false,
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
            'items'=> ComboHelper::getCboUms(),
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
        [
            'name'  => 'codart',
            'title' => 'codart',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
       'enableError' => true,
          'headerOptions' => [
                'style' => 'width: 15%',
                //'class' => 'day-css-class'
            ],  
            
            ],
       
        [
            'name'  => 'descripcion',
            'title' => 'descripcion',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
       'enableError' => true,
            'headerOptions' => [
                'style' => 'width: 50%',
                //'class' => 'day-css-class'
            ],
            
            //'items'=> ComboHelper::getCboUms(),
            ],
        [
            'name'  => 'ptotal',
            'title' => 'ptotal',
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
<?php Pjax::end();  ?>