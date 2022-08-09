<?php
use yii\widgets\ActiveForm;

use yii\helpers\Html;
?>
<?php 


?>
<?= dosamigos\gallery\Carousel::widget([
    'items' => $items, 'json' => false,
    'clientEvents' => [
        'onslide' => 'function(index, slide) {
            console.log(slide);
        }'
]]);

?>