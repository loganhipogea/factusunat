<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\helpers\FileHelper;
use common\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;
//use common\helpers\FileHelper;
use dosamigos\chartjs\ChartJs;
 use kartik\date\DatePicker;
use frontend\modules\cc\models\CcGastos;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>


     <div class="box-body">
         <div>
      <?php 
        $avance=$model->porcentajeAvance();
         $bloqueado=($avance==100)?true:false; 
      $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      
          
        <div class="col-md-12">
            <div class="form-group ">
            <div class="btn-group">
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
           <?php    $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
               'isImage'=>false,
               'idModal'=>'imagemodal',
               'modelid'=>$model->id,
                'extension'=> \yii\helpers\Json::encode(array_merge(['pdf','jpg','png','svg','jpeg'])),
               'nombreclase'=> str_replace('\\','_',get_class($model))
               ]); ?>
            <?=(!$model->isNewRecord)?Html::button('<span class="fa fa-clip"></span>   '.Yii::t('base.names', 'Adjuntar imagen'), ['class' => 'botonAbre btn btn-success','href' => $url,'id'=>'btn-add-usuarios']):''?> 
 

                  
              </div>       
            </div>
        </div>
    
         
         
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'codocu')->
                            dropDownList(ComboHelper::getCboDocuments(),
                            ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                                    ]
                                ) ?>
                    </div>    
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'prefijo')->textInput() ?>
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'numero')->textInput() ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">   
                            <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
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
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
                        
                         <?php Pjax::begin(['id'=>'pjax-moneda']); ?>  
                        <?= $form->field($model, 'codmon')->
                             dropDownList(ComboHelper::getCboMonedas(),
                            ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>$bloqueado,
                                 ]
                                ) ?>
                      <?php Pjax::end(); ?> 
                    </div>   
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
                        <?= $form->field($model, 'glosa')->textInput() ?>
                    </div>        
                   
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                        <?= $form->field($model, 'rucpro')->textInput() ?>
                    </div> 
                    
                   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
                             <?php Pjax::begin(['id'=>'pjax-monto']); ?> 
                            <?= $form->field($model, 'monto_a_rendir')->textInput(['disabled'=>true,]) ?>
                            <?php Pjax::end(); ?> 
                   </div> 
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'detalle')->textArea() ?>
                        </div>
     <?php ActiveForm::end(); ?>   
             </div>          
        </div>         
    <?php 
    $avanceCali=$model->porcentajeAvanceCalificacion();
    Pjax::begin(['id'=>'grilla-gastos']); ?>                  
    <div class="form-group no-margin">
       <div class="btn-group">   
    <?php
    // $url= Url::to(['cuentas/mod-crea-rendicion','id'=>$model->id,'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
    // echo  Html::button(yii::t('base.names','Costo directo'), ['href' => $url, 'title' => yii::t('base.names','Costo directo'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
    /* $url= Url::to(['ceco/mod-crea-calificacion','id'=>$model->id,'tipo'=>$model->codigo_costo_indirecto(),'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('base.names','Costo indirecto'), ['href' => $url, 'title' => yii::t('base.names','Costo indirecto'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-danger']); 
   $url= Url::to(['ceco/mod-crea-calificacion','id'=>$model->id,'tipo'=>$model->codigo_costo_orden(),'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('base.names','Colector'), ['href' => $url, 'title' => yii::t('base.names','Agregar a Colector'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-warning']); 
   */
   echo ".";
   ?>
                 
    </DIV>
        
    </DIV>
                  <br>
             <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?=$avance?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$avance?>%</div>
            </div>  
            <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?=$avanceCali?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$avanceCali?>%</div>
            </div> 
     
     <?php 
     
//var_dump($avance,$model->faltante(),$model->acumulado());
     /*$falta=$model->faltante();if($falta>0){ ?>
    <div class="alert label-warning">Existe un monto de : <?=h::formato()->asDecimal($falta,2)?> que no se ha calificado</div>
     <?php }*/?>
   <?php
   $formato=h::formato();
//var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); 
   ?>
      <div style="overflow:auto;">
    <?= GridView::widget([
        'dataProvider' =>/*(new \yii\data\ActiveDataProvider([
                        'query'=> \frontend\modules\cc\models\CcCompras::find()
                        ->andWhere(['parent_id'=>$model->id])
                        ]))*/$dataprovider,
         //'summary' => '',
        //'filter'=> $searchModel,
        'filterModel' => $searchModel,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
             [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/cc/cuentas/ajax-show-comprobante']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
             ], 
                 [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model)),'extension'=> \yii\helpers\Json::encode(array_merge(['pdf'], FileHelper::extImages())),
                           ]);
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
			    $url= Url::to(['/cc/cuentas/edit-comprobante','id'=>$model->id,'modo'=>3,'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0']);
                            },
                        'delete' => function ($url,$model) use($bloqueado) {
                              IF($model->activo && !$bloqueado){
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-anula-comprobante','id'=>$model->id]);
                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                              }else{
                                  return '';
                              }
                             
			    }
                        
                    ]
                ],
            
              ['attribute' => 'codocu',
                'format'=>'raw',
                'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                         if(!$model->activo){                            
                           return '<span style="text-decoration:line-through;">'.$model->documento->desdocu.'</span>';
                          }else{
                             
                             return $model->documento->desdocu;
                                                
                             } 
                             //RETURN $model->ceco_id;
                                                                               
                            } 
                
                ], 
               'glosa',
             ['attribute' => 'Av.',
                'format'=>'raw',
                'value'=>function($model){ 
                             //RETURN $model->ceco_id;
                             return $model->PorcentajeAvanceCalificacion(true).'%';                                                   
                            } 
                
                ], 
             ['attribute' => 'prefijo',
                'format'=>'raw',
                'value'=>function($model){ 
                             //RETURN $model->ceco_id;
                             return $model->prefijo;                                                   
                            } 
                
                ], 
             ['attribute' => 'numero',
                'format'=>'raw',
                'value'=>function($model){                        
                             return $model->numero;                                                   
                             } 
                
                ], 
                 ['attribute' => 'rucpro',
                'format'=>'raw',
                'value'=>function($model){                        
                             return $model->rucpro;                                                   
                             } 
                
                ],        
                 
               ['attribute' => 'despro',
                'format'=>'raw',
                'value'=>function($model){                        
                             return substr($model->despro(),0,25);                                                   
                             } 
                
                ], 
                    
            ['attribute' => 'monto',
                'format'=>'raw',
                 'contentOptions'=>['style'=>'text-align:right;'],
                'value'=>function($model) use($formato){
                             if(!$model->activo){                            
                           return '<span style="text-decoration:line-through;">'.$formato->asDecimal($model->monto,3).'</span>';
                          }else{
                             
                             return $formato->asDecimal($model->monto,3);
                                                
                             } 
                  }
                ], 
             
             
           ['class' => '\common\components\columnGridAudit',],
        ],
    ]); ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
            <p class="text-right">
                 <?=yii::t('base.names','Monto rendido : '). '  S/. '.$formato->asDecimal($model->acumulado(),2) ?>
            </p>
                       
        </div> 
      </div>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
        'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'grilla-gastos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
          
         
       
    <?php
     if($avance >100){
           echo  Html::button(yii::t('base.names','Compensar'), [ 'title' => yii::t('base.names','Compensar'),'id'=>'btn_compensar', 'class' => 'btn btn-warning']); 
    
       }elseif ($avance==100) {
            echo  Html::button(yii::t('base.names','Revertir Compensación'), [ 'title' => yii::t('base.names','Revertir'),'id'=>'btn_revertir_compensacion', 'class' => 'btn btn-danger']); 
    
      }elseif($avance <100){
          $url= Url::to(['cuentas/mod-crea-rendicion','id'=>$model->id,'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
            echo  Html::button(yii::t('base.names','Agregar Comprobante'), ['href' => $url, 'title' => yii::t('base.names','Comprobante'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
     
      }
     /* $url= Url::to(['ceco/mod-crea-calificacion','id'=>$model->id,'tipo'=>$model->codigo_costo_indirecto(),'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('base.names','Costo indirecto'), ['href' => $url, 'title' => yii::t('base.names','Costo indirecto'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-danger']); 
   $url= Url::to(['ceco/mod-crea-calificacion','id'=>$model->id,'tipo'=>$model->codigo_costo_orden(),'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
     echo  Html::button(yii::t('base.names','Colector'), ['href' => $url, 'title' => yii::t('base.names','Agregar a Colector'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-warning']); 
   */

   ?>               
        <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_compensar',
            'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/cc/cuentas/ajax-compensa-fondo','id'=>$model->id]),
            'id_input'=>'btn_compensar',
            'idGrilla'=>'grilla-gastos'
      ])  ?>          
       <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_revertir_compensacion',
           'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/cc/cuentas/ajax-revierte-fondo','id'=>$model->id]),
            'id_input'=>'btn_revertir_compensacion',
            'idGrilla'=>'grilla-gastos'
      ])  ?>               
    <?php Pjax::end(); ?>
                 
                
                 
             </div>
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             
                    <?PHP 
                  
 /*ECHO ChartJs::widget([
    'type' => 'doughnut',
    'options' => [
        'height' => 150,
        'width' => 150
    ],
    'data' => [
        'labels' =>['Rendido','Faltante'],
        'datasets' => [
           [
                'data' =>[$model->acumulado(),$model->faltante()],
                'label' => '',
                'backgroundColor' =>['#3CE74B','#E7E03C'],
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 1,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
            
        ]
    ]
]);
   */
?>
             
             </div> 
             
      
           
         
     
    
    <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'cccompras-rucpro',
            'idGrilla'=>'234_descri_proveedor'
      ])  ?>   
  
     
  
     

  
