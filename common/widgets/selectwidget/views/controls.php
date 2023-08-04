<?php 
use yii\helpers\Html;
?>
<?php
 
$options=array_merge($opcionesBase,
        ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
           'class'=>'probandoSelect2',
          // 'labelOptions'=>['label'=>false],
                      
                        ]);
if($multiple){
    $options['multiple']=true;
   //var_dump($options['data']); die();
    //$options['name']=$options['name'].'[]';
    $options['data']=$datos;
    $options['tags']=true;
}


?>
<?php $widget= $form->field(
        $model,(is_null($orden))?$campo:'['.$orden.']'.$campo,$opciones)->
            dropDownList($valoresLista,
                   $options
                    ) ?>
<?php 
    if($tabular)
     $widget->label(false);  

?>
<?=$widget?>



