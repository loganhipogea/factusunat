<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\ComboHelper;
use common\models\masters\Tipocambio;
use common\helpers\h;
use yii\widgets\Pjax;
use yii\grid\GridView as grid;

use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-form">
 
    
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin([
        'id'=>'Form_general',
       // 'enableAjaxValidation'=>true
        ]); ?>  
        <div class="form-group">
        <?= Html::submitButton('<span class="fa fa-save"></span>- -'.Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
             <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <?= $form->field($model, 'sunat_tipodoc')->
            dropDownList(['01'=>'FACTURA','02'=>'BOLETA'],
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        'disabled'=>true,
                        ]
                    ) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'rucpro')->textInput(['maxlength' => true]) ?>
        </div>
   
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
          <div class="form-group field-zona_pk">
                <label class="control-label" for="zona_pk">
                    Despro
                </label>
             
                <input type="text"  
                       id="zona_pk"
                       class="form-control" 
                       value="<?=($model->isNewRecord)?'':$model->clipro->despro?>"
                       name="ComFactudet[despro]"                       
                       disabled
                  >  
              
            </div>   
         
         
           <?php  /*= $form->field($model, 'despro')->textInput([
               'id'=>'zona_pk',
               'disabled'=>true,
               //'value'=>(empty($model->rucodni))?'':$model->clipro->despro,
               'maxlength' => true])*/ ?>   
         
         

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'codmon')->
            dropDownList([Tipocambio::COD_MONEDA_DOLAR=>Tipocambio::COD_MONEDA_DOLAR,
                Tipocambio::COD_MONEDA_BASE=>Tipocambio::COD_MONEDA_BASE] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'codsoc')->
            dropDownList(['A'=>'SOCIEDAD','B'=>'SOCIEDAD2'] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'tipopago')->
            dropDownList(ComboHelper::getTablesValues('com_ov.tipopago') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
        </div>
   
        
      
           
            <?php ActiveForm::end(); ?>
            <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'comfactura-rucpro',
            'idGrilla'=>'zona_pk'
            ])  ?>
   </div> 
    
    <?php Pjax::begin(['id'=>'grilla-contactos']); ?>
   
   <?php 
   $gridColumns=[
       
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['masters/clipro/editacontacto','id'=>$model->id,'gridName'=>'grilla-contactos','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ],
           
           
        [
            'attribute' => 'item',
           
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'cant',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
        'codart',
                            
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'codum',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descripcion',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
       [
           
            'attribute' => 'punit',
          
         ], 
       [
           
            'attribute' => 'pventa',
          
         ],
                            [
           
            'attribute' => 'igv',
          
         ],
   ];
   echo grid::widget([
    'dataProvider'=> new \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComFactudet::find()-> 
                andWhere(['factu_id'=>$model->id])
    ]),
   // 'filterModel' => $searchModel,
       'summary' => '',
    'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
   ?> 
   
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'grilla-contactos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>



    <?php Pjax::end(); ?>    
   
<?php
$url= Url::to(['/com/com/modal-crea-itemfac','id'=>$model->id,'gridName'=>'grilla-contactos','idModal'=>'buscarvalor']);
 
  echo  Html::button('<span class="fa fa-user"></span>'.yii::t('base.verbs','Crear Contacto'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>'grilla-contactos',    'class' => 'botonAbre btn btn-success']); 

  
 /* use lo\widgets\modal\ModalAjax;

echo ModalAjax::widget([
    'id' => 'createCompany',
    'header' => 'Create Company',
    'toggleButton' => [
        'label' => 'New Company',
        'class' => 'btn btn-primary pull-right',
        'id'=>'mibotonmodal'
       // 'style'=>'visibility:hidden',
        
    ],
    'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
    'clientOptions' => ['tabindex'=>'','backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);*/
 ?>  
</div>
  

