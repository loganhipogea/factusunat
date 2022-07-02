<?php 
use yii\helpers\Html;
?>
<?php
 
$options=array_merge($opcionesBase,['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
           'class'=>'probandoSelect2',
          // 'labelOptions'=>['label'=>false],
                      
                        ]);
if($multiple){
    $options['multiple']='multiple';
    $options['data']=$datos;
}


?>
<?php $widget= $form->field($model,(is_null($orden))?$campo:'['.$orden.']'.$campo,$opciones)->
            dropDownList($valoresLista,
                   $options
                    ) ?>
<?php if(isset($tabular)){
    if($tabular)
  $widget->label(false);  
} 
?>
<?=$widget?>



