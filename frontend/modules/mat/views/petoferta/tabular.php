<?php  use unclead\multipleinput\TabularInput;
use yii\helpers\Html;
use common\widgets\selectwidget\selectWidget;
?>
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
            'name'  => 'item',
            'title' => 'Item',
            'type'  => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
       'enableError' => true,
            ],
            ['name'  => 'codart',
            'title' => 'CODIGO',
            'type'  =>selectWidget::className(),
        'options'=>[
            'tabular'=>true,          
            'form'=>$form,
            'campo'=>'codart',
            'ordenCampo'=>1,
            'addCampos'=>[1],           
                              ],
        'enableError' => true,
            ],
        
    ],
]) ?>