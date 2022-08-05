<?php
use yii\helpers\Url;
use common\helpers\h;
use common\helpers\ComboHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\widgets\Pjax;
?>
<?php $this->title = Yii::t('base.verbs', 'Assign document: {name}', [
    'name' => $model->fullName(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigotra, 'url' => ['view', 'id' => $model->codigotra]];
$this->params['breadcrumbs'][] = Yii::t('base.verbs', 'Assign');
?>
<h4><?=$this->title?></h4>
<div class="box box-success">
    <?php $form = ActiveForm::begin([
    'id' => 'trabajadores-form',
    'enableAjaxValidation' => true,
    'fieldClass' => 'common\components\MyActiveField',
    //'options'=>['enctype' => 'multipart/form-data'],'fieldClass' => '\common\components\MyActiveField'
    ]); ?>
    <div class="box-body">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codigotra')->textInput(['disabled'=>true,'maxlength' => true]) ?>
  </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    
    <?= $form->field($model, 'ap')->textInput(['disabled'=>true,]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'am')->textInput(['disabled'=>true,]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'nombres')->textInput(['disabled'=>true,]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'dni')->textInput(['disabled'=>true,]) ?>
</div>
    
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'codpuesto')->
            dropDownList($model->comboDataField('codpuesto') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        'disabled'=>true,
                        ]
                    )  ?>
</div>
    
   
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'domicilio')->textInput(['disabled'=>true,'maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'telfijo')->textInput(['disabled'=>true,'maxlength' => true]) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'telmoviles')->textInput(['disabled'=>true,'maxlength' => true]) ?>
</div>
   
    </div> 
    
    

    
   
    <?php ActiveForm::end(); ?>
    
    


    <?php Pjax::begin([
        'id'=>'gridTraba'
    ]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $url=Url::toRoute(['masters/trabajadores/modal-assign-document','id'=>$model->id,'gridName'=>'gridTraba','idModal'=>'buscarvalor',]);   ?>
   <?php  
     echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Add document'), ['href' => $url, 'title' => 'Nuevo documento '.$model->fullName(),'id'=>'btn_adrtrtrteses',    'class' => 'botonAbre btn btn-success']); 
    ?>
    

    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query'=> common\models\masters\Docutrabajadores::find()
        ]),
       // 'filterModel' => $searchModel,
         'summary' => '',
        'columns' => [
           
                [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },                 
                     'detailUrl' =>Url::toRoute(['/masters/trabajadores/ajax-expand-attachments']),
                     'expandOneOnly' => true
                ], 
           [
               'attribute'=>'codocu',
               'format'=>'raw',
               'value'=>function($model){ 
                  if($model->hasAttachments())
                   return Html::a("<span class='glyphicon glyphicon-download-alt'></span>".$model->documento->desdocu,$model->files[0]->url,['data-pjax'=>'0']);
               }
           ],
            'numero',
            'vence',
            'descripcion',
           
           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{edit}{attach}{delete}',
                'buttons'=>[
                   'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','idModal'=>'imagemodal',
                             'ext'=> \yii\helpers\Json::encode(common\helpers\FileHelper::extImages()+common\helpers\FileHelper::extDocs()) ,
                             'modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
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
			    $url= Url::to(['/masters/trabajadores/modal-edit-document','id'=>$model->id,'gridName'=>'pjax-detmat','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                             'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                   ]
                ],
        ],
    ]); ?>
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBancos',
            'idGrilla'=>'gridTraba',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
           'posicion'=> \yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    <?php Pjax::end(); ?>
</div>