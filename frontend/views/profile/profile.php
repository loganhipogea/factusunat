
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
 use kartik\tabs\TabsX;
use yii\helpers\Html;
use common\helpers\h;
use yii\bootstrap\ActiveForm;

$this->title = '   '.yii::t('base.names','Datos de usuario');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h4><span class="fa fa-user"></span><?= Html::encode($this->title) ?></h4>
 <div class="box box-success">
    

 
        
             
            
            
              <?php  
              $form = ActiveForm::begin(['id' => 'profile-form','options' => ['enctype' => 'multipart/form-data']]); ?>
                  
     <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton(Yii::t('base.names', 'Guardar'), ['class' => 'btn btn-success']) ?>
          <?php echo  Html::button('<span class="fa fa-refresh"></span>   '.Yii::t('base.names', 'Generar hash'), ['id'=>'boton_hash','class' => 'btn btn-warning']);?>
              

            </div>
        </div>
    </div>
      <div class="box-body">
     
     
               <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= \common\widgets\imagewidget\ImageWidget::widget(['name'=>'imagenrep','model'=>$model]); ?>
   </div>
    
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= Html::label(yii::t('base.names','Usuario'),'45545ret',['class' => 'control-label']) ?>
                <?=  Html::input('text', 'username', h::userName(),['disabled'=>'disabled','class' => 'form-control']) ?>
             </diV>
            
             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= Html::label(yii::t('base.names','Ultimo acceso'),'fd5656',['class' => 'control-label']) ?>
                <?=  Html::input('text', 'username', h::user()->lastLoginForHumans(),['disabled'=>'disabled','class' => 'form-control']) ?>
             </diV>
            
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?= Html::label(yii::t('base.names','Creado'),'fdtt5656',['class' => 'control-label']) ?>
                <?=  Html::input('text', 'username', h::user()->getSince(),['disabled'=>'disabled','class' => 'form-control']) ?>
             </diV>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <?=$form->field($identidad,'email')->textInput() ?>
             </diV>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= Html::checkbox('agreeff',h::user()->isActive(), [ 'disabled'=>'disabled', 'label' =>yii::t('base.names','Enabled')]) ?>
             </diV>
         
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'names')->textInput(['autofocus' => true]) ?>
                    </diV>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($model, 'duration')->textInput(['autofocus' => true]) ?>
                    </diV>
            
             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                 <?php \yii\widgets\Pjax::begin(['id'=>'hash-pjax']); ?>
                <?= $form->field($model, 'hash')->textInput(['disabled' => true]) ?>
                     <?php \yii\widgets\Pjax::end(); ?>
             </diV>
       
                
            
               
                
            <?php ActiveForm::end(); ?>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

 </div>           
      <?php 
 echo TabsX::widget([
     'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
            'label' =>'<i class="fa fa-bookmark"></i> '.yii::t('base.names','Favoritos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=>$this->render('_tab_profile_favoritos'),
            'active' => true,
             'options' => ['id' => 'tnID3'],
        ],
        [
            'label' =>'<i class="fa fa-list-ul"></i> '. yii::t('base.names','Registro Acceso'), //$this->context->countDetail() obtiene el contador del detalle
           'content'=>$this->render('_tab_profile_audit'),
            'active' => false,
             'options' => ['id' => 'myy6nID4'],
        ],
         /*[
            'label' =>'<i class="fa fa-list-ul"></i> '. yii::t('base.names','Registro Actividad'), //$this->context->countDetail() obtiene el contador del detalle
           'content'=>$this->render('_tab_log_user'),
            'active' => false,
             'options' => ['id' => 'myy6nete56ID4'],
        ],*/
      
    ],
]); 
    ?>       
       
    </div>
    <br>
</div>
   
</div>
 <?php
$string5="$('#boton_hash').on( 'click', function(){ 
       $.ajax({
              url: '".\yii\helpers\Url::to(['/profile/hash-user'])."', 
              type: 'get',
              dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {
              var n = Noty('id');
                       $.noty.setType(n.options.timeout, 10000); 
                       $.pjax.reload({container: '#hash-pjax',async:false});
                         if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             })";
  $this->registerJs($string5, \yii\web\View::POS_END);
?>  