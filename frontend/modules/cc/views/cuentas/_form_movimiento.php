<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\modules\cc\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
 use kartik\date\DatePicker;
 use common\helpers\FileHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>


     <div class="box-body">
      <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group">
             <div class="btn-group">
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
            <?php 
            $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model)),'extension'=> \yii\helpers\Json::encode(array_merge(['pdf'], FileHelper::extImages())),
                       ]);
            echo Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
            ?>
           <?PHP 
            if(!$model->iSnewRecord){
              ECHO common\widgets\auditwidget\auditWidget::widget(['model'=>$model]);   
            }
           
           ?>
                  
            </div>
            </div>
        </div>
    </div>
     
  
      <div class="box-body">
          
       <?php if(empty($model->cuenta_id)){   ?>
         <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">    
                 <?= $form->field($model, 'cuenta_id')->
            dropDownList(comboHelper::getCboCuentas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
            </div>
          
        <?php }  ?>  
     
 <?php //if($model->isScenario($model::SCE_PAGO_RENDIR_PERSONA)){  ?> 
  <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">    
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
  <?php  //} ?>  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fechaop')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
 </div>
  
  

  
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
    
 <?= $form->field($model, 'glosa')->textInput() ?>

</div>  
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
  <?php
     $zonaMonto='pjax_monto';
     
    Pjax::begin(['id'=>$zonaMonto]) ?>
   <?= $form->field($model, 'monto')->textInput(['disabled'=>$model->hasChilds()]) ?>
  <?php Pjax::end() ?>
   </div>

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'glosa')->textarea() ?>
  </div>
          
     

     
    <?php ActiveForm::end(); ?>
          
       <?php if(!$model->isNewRecord){ ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?php
    $zonaAjax='grilla-materiales';
    Pjax::begin(['id'=>$zonaAjax]);
    
    ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
   <?=\frontend\modules\cc\models\CcRendicion::find()
                        ->andWhere(['movimiento_id'=>$model->id])
                        ->createCommand()->rawSql?>
   <?= GridView::widget([
        'dataProvider' =>(new \yii\data\ActiveDataProvider([
                        'query'=> \frontend\modules\cc\models\CcRendicion::find()
                        ->andWhere(['movimiento_id'=>$model->id])
                        ])),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
             [
        'class' => 'yii\grid\CheckboxColumn',
                 'checkboxOptions' => function ($model, $key, $index, $column) {
                         $url = \yii\helpers\Url::to([$this->context->id.'/ajax-guarda-id-req-sesion','id'=> $model->id]);                              
                        return ['value' => $model->id,'family'=>'pigmalion', 'rel'=>$url,'id'=>$model->id];
                            }
        // you may configure additional properties here
                    ],
                 [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model) {
                                        
                                            $url= Url::to(['/cc/cuentas/edit-fondo','id'=>$model->id,]);
                                         
                                                return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0']);
                                          },
                       'delete' => function ($url,$model)use($zonaAjax) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id,'gridName'=>$zonaAjax]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ],
           
           // 'prefijo',
             'numero',
             ['attribute' => 'monto',
                'format'=>'raw',
                'value'=>function($model){                        
                             return $model->monto;                                                   
                             } 
                
                ], 
                    
            ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        
                        
                             return $model->descripcion; 
                                                
                             } 
                
                ], 
             
             
           ['class' => '\common\components\columnGridAudit',],
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>$zonaAjax,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
          
          <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancosss',
            'idGrilla'=>$zonaAjax,
            'family'=>'pigmalion',
          'type'=>'POST',
           'evento'=>'change',
           'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
         
    <?php Pjax::end(); ?>
   <?php
    $url= Url::to(['mod-crea-comprobante','id'=>$model->id,'gridName'=> \yii\helpers\Json::encode([$zonaAjax,$zonaMonto]),'idModal'=>'buscarvalor']);
    echo  Html::button(yii::t('base.verbs','Agregar comprobante'), ['href' => $url, 'title' => yii::t('base.names','Agregar Comprobante'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
     ?>
    <?php
    $url= Url::to(['mod-crea-fondo','id'=>$model->id,'gridName'=>\yii\helpers\Json::encode([$zonaAjax,$zonaMonto]),'idModal'=>'buscarvalor']);
    echo  Html::button(yii::t('base.verbs','Agregar Fondo'), ['href' => $url, 'title' => yii::t('base.names','Agregar fondo'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
     ?>
  </div> 
  <?php  } ?>        
     
</div>
    </div>
