<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use yii\helpers\Url;

use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
   
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-form">
     <div class="box-body">
      <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
          $operacion=($model->isNewRecord)?'new-detail-invoice':'edit-detail-invoice';
          
          $url=\yii\helpers\Url::to(['/com/com/'.$operacion,'id'=>$id]);
              
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
     
  
      <div class="box-body">
      <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'item')->textInput(['disabled'=>true]) ?>
   </div> 
    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'cant')->textInput() ?>
   </div> 
    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'punitgravado')->textInput() ?>
   </div> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'tabular'=>false,
            'form'=>$form,
            'campo'=>'codart',
              'ordenCampo'=>2,
                'addCampos'=>[1,2,6],
        ]);  ?>


        </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= 
                   //$model->activo=false;
            $form->field($model, 'sunat_codtributo')->
            dropDownList(h::sunat()->gRaw('s.05.ttributo')->combo()->data ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

        </div>   
       
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= 
                   //$model->activo=false;
            $form->field($model, 'sunat_codtipoafectacion')->
            dropDownList(h::sunat()->gRaw('s.07.tafectacion')->combo()->data ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

        </div>   
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
