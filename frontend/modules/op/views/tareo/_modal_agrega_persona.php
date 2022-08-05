<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\op\helpers\ComboHelper;
  use kartik\time\TimePicker;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
 //use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
           $operacion=($model->isNewRecord)?'modal-agrega-persona':'modal-edita-persona';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/op/tareo/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/op/tareo/'.$operacion,'id'=>$id]);  
             }
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
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
             <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'hinicio')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

            </div>
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'hfin')->widget(TimePicker::className(), ['pluginOptions' => ['showMeridian' => false]]);?>
     

            </div>
         
     
         
         
         
    
   
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true/*,'disabled'=>!$model->activo*/,]) ?>

 </div>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?php echo ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::procesos(),
               'campo'=>'proc_id',
               'idcombodep'=>'optareodet-os_id',
              
                   'source'=>[\frontend\modules\op\models\OpOs::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'proc_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div>       
          
          
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?php echo ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?ComboHelper::Os($model->idProc()):ComboHelper::Os($model->proc_id),
               'campo'=>'os_id',
               'idcombodep'=>'optareodet-detos_id',              
                   'source'=>[\frontend\modules\op\models\OpOsdet::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'os_id'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div> 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">  
     
<?php 
/*$s=$model->ses;
print_r($s->sesion[$model->ses::NOMBRE_SESION]);
echo "<br>";
echo $s->idProceso."=>ID PROCESO<br>";
echo $s->idOs."=>ID OS <br>";
echo $s->idDetos."=>ID detOS <br>";

echo "<br>";
echo "proc_id=>".$model->proc_id."<br>";
echo "os_id=>".$model->os_id."<br>";
echo "detos_id=>".$model->detos_id."<br>";*/
?>
 <?php echo  $form->field($model, 'detos_id')->
            dropDownList(($model->isNewRecord)?ComboHelper::actividadesOs($model->idOs()):ComboHelper::actividadesOs($model->os_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textArea(['maxlength' => true,/*'disabled'=>!$model->activo,*/]) ?>
 </div>        
  <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">  
    <?php /*echo 
            $form->field($model, 'tarifa_id')->
            dropDownList(ComboHelper::planes(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>!$model->activo,
                        ]
                    ) */ ?>
</div>        
  
  
      
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



