<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\widgets\Pjax;
use common\helpers\h;
use yii\grid\GridView;
 use kartik\date\DatePicker;
 use common\widgets\selectwidget\selectWidget;
 use common\widgets\inputajaxwidget\inputAjaxWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

?>

<div class="mat-req-form">
    <br>
    <?php $form = ActiveForm::begin([
   // 'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
       <?php Pjax::begin(['id'=>'botones_cabecera']); ?>   
        <div class="col-md-12">
            <div class="btn-group">
             
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
          <?=(!$model->isCreado())?common\widgets\auditwidget\auditWidget::widget(['model'=>$model]):''?>  
            <?php  
              if($model->isCreado())
              echo Html::button( '<span class="fa fa-check-circle"></span>   '.Yii::t('base.names', 'Aprobar'),
                  ['class' => 'btn btn-success','href' => '#','id'=>'btn-aprobar']
                 );
              ?> 
             <?php  
              if($model->isAprobado())
              echo Html::button( '<span class="fa fa-dropbox"></span>   '.Yii::t('base.names', 'Reservar'),
                  ['class' => 'btn btn-warning','href' => '#','id'=>'btn-reservar']
                 );
              ?>       
            </div>
        </div>
        <?php Pjax::end(); ?>   
    </div>
      <div class="box-body">
    

  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,
         'style'=>"font-weight:600;color:#740fd6;",
         'disabled'=>true]) ?>

 </div>
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechasol')->widget(
        DatePicker::classname(), [
         'name' => 'fechasol',
            'language' => h::app()->language,
            'options' => [
                'placeholder' =>yii::t('base.names', '--Seleccione un valor--'),
                'disabled'=>$model->isAuto(),
                ],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechaprog')->widget(
        DatePicker::classname(), [
         'name' => 'fechaprog',
            'language' => h::app()->language,
            'options' => [
                
                'placeholder' =>yii::t('base.names', '--Seleccione un valor--'),
                'disabled'=>$model->isAuto(),
                
                ],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
       <?= $form->field($model, 'codest')->textInput(['style'=>'color:#F84E35; font-weight:700; font-size:1.2em','value'=>$model->comboValueText('codest'),'maxlength' => true,'disabled'=>true  ]) ?>  
  </div>       
  <?php
    //if($model->isAuto()){  
  ?>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?php 
  // $necesi=new Parametros;
     
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>2,
         'addCampos'=>[3,4],
        //'disabled'=>true,
        ]);  ?>


 </div>
 <?php
   // }
  ?>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>$model->isAuto()]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'texto')->textarea(['rows' => 2,'disabled'=>$model->isAuto()]) ?>

 </div>
  
     
    <?php ActiveForm::end(); ?>
  <?php if(!$model->isNewRecord){ ?>
    <?php Pjax::begin(['id'=>'grilla-materiales']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>(new \frontend\modules\mat\models\MatDetreqSearch())->search_by_req($model->id),
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
			    $url= Url::to(['/mat/mat/mod-edit-mat','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              IF(!$model->isBloqueado() && !$model->isCreatedFromOrder()){
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              }
			    }
                        
                    ]
                ],
              
            'item',
             'um',
             ['attribute' => 'cant',
                'format'=>'raw',
                'value'=>function($model){
                        
                          if($model->isAnulado()){                            
                           return '<span style="text-decoration:line-through;">'.$model->cant.'</span>';
                          }else{
                             return $model->cant; 
                          }                         
                             } 
                
                ], 
              'codart',              
            ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        
                          if($model->isAnulado()){                            
                           return '<span style="text-decoration:line-through; color:red;">'.$model->descripcion.'</span>';
                          }else{
                             return $model->descripcion; 
                          }                         
                             } 
                
                ], 
             ['attribute' => 'imagen',
                'format'=>'raw',
                'value'=>function($model){
                        
                          if(!empty($model->codart)){
                             $material=$model->material;
                            if($material->hasAttachments())
                            return \yii\helpers\Html::img ($material->files[0]->url,['width'=>50,'height'=>50]);
                            
                          }                           
                              } 
                
                ], 
              'imptacion',
           ['class' => '\common\components\columnGridAudit',],
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-materiales',
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
            'idGrilla'=>'grilla-materiales',
            'family'=>'pigmalion',
          'type'=>'POST',
           'evento'=>'change',
           'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?> 
      
    <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
           // 'isHtml'=>true,//Devuelve datos Html
            //'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST', 
           // 'data'=>['idpet'=>$model->id],
            'evento'=>'click',
            'ruta'=>Url::to(['/mat/mat/ajax-aprobar-req','id'=>$model->id]),
            'id_input'=>'btn-aprobar',
            'idGrilla'=>'grilla-materiales',
           'otherContainers'=>['botones_cabecera'],
      ])  ?>        
          
          
    
   <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
           // 'isHtml'=>true,//Devuelve datos Html
            //'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST', 
           // 'data'=>['idpet'=>$model->id],
            'evento'=>'click',
            'ruta'=>Url::to(['/mat/mat/ajax-reservar-all','id'=>$model->id]),
            'id_input'=>'btn-reservar',
            'idGrilla'=>'grilla-materiales',
           'otherContainers'=>['botones_cabecera'],
      ])  ?>        
          
          
    <?php Pjax::end(); ?>
   <?php  
      if(!$model->isAuto()){
                $url= Url::to(['mod-agrega-mat','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                echo  Html::button(yii::t('base.verbs','Agregar material libre'), ['href' => $url, 'title' => yii::t('base.names','Agregar Material'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
                $url= Url::to(['mod-agrega-mat','id'=>$model->id,'imputado'=>'y','gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                echo  Html::button(yii::t('base.verbs','Agregar material imputado'), ['href' => $url, 'title' => yii::t('base.names','Agregar Material'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
 
        }
  }
?>       
</div>
    </div>
