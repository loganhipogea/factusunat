<?php

use yii\helpers\Html;


?>
<div class="com-ov-create"> 
   <?php $this->registerCssFile('@web/css/fix_form_ventas.css');   ?>
    <?= $this->render('_form_plus', [
        'model' => $model,'models' => $models,
    ]) ?>

</div>
