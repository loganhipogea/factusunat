<?php
use yii\widgets\ActiveForm;
use yii\bootstrap4\Carousel;
use yii\helpers\Html;
?>
<?php 


?>
<?php echo dosamigos\gallery\Carousel::widget([
    'items' => $items, 'json' => false,
    'clientEvents' => [
        'onslide' => 'function(index, slide) {
            console.log(slide);
        }'
]]);

?>
