<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
use yii\helpers\Json;
//use kartik\grid\GridView;
use yii\grid\GridView;
USE common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
//$this->title = Yii::t('base.names', 'Materials');
//$this->params['breadcrumbs'][] = $this->title;
?>
         
  <?php 
    $zona_refresh='grilla-detalle-by-partidas'.$model->id;
     Pjax::begin(['id'=>$zona_refresh]);
    
    ?>

  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
         <?= GridView::widget([
        'dataProvider' =>New \yii\data\ActiveDataProvider([
            'query'=> \frontend\modules\prd\models\PrdPlanosRevisiones::find()->andWhere(['plano_id'=>$model->id])->orderBy(['rev'=>SORT_DESC]),
            'pagination' => false,
        ]),
         'summary' => '',
       
       
        'columns' => [
            
              
            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}{eye}',
               'buttons' => [
                    
                                
                                'edit' => function ($url,$model) use($zona_refresh)   {
			    $url= Url::to(['/prd/planos/modal-edita-plano','id'=>$model->id,'gridName'=>$zona_refresh,'idModal'=>'buscarvalor']);
                              
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                               
			   $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                         'attach' => function($url, $model) use($zona_refresh)  {  
                          $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'extension'=>'pdf',
                             'grillas'=>$zona_refresh,
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
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
                       'eye' => function ($url,$model) {
                               
			   $url = \yii\helpers\Url::to(['/prd/planos/ajax-view-pdf','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-search"></span>', '#', ['id'=>'lamelita','title'=>$url,/*'id'=>$model->codparam,*/'family'=>'claro','data-pjax'=>'1',/*'title' => 'Borrar'*/]);
                            }, 
                    ]
                ],
              'cambio',  
              ['attribute' => 'fecha',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->fecha;
                              } 
                
                ], 
                   
                 'rev',           
               
        ],
    ]); ?>
  </div>
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12"> 
         <?php 
         
         
         if($model->hasAttachments()) { 
       //echo $model::className();die();
       //echo $model->files[0]->urlTempWeb ;
       echo $this->render('@frontend/views/comunes/view_pdf', [
                        'urlFile' => $model->files[0]->urlTempWeb,
                         'width' => 700,
                            'height' => 900,
            ]); 
         } ?>
  </div>  
   
    


    <?php 
    
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos'.$model->id,
        //'otherContainers'=>['grilla-partidas'],
            'idGrilla'=>$zona_refresh,
            'family'=>'claro',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
       
    
    
    
     Pjax::end();
    ?>
  <button id="martico" class="topetope">presionar</button>
     <?php  
   
   $js4="$('#martico.topetope').on('click', function () {
         alert('holis');
        })
        ";
     $this->registerJs($js4, \yii\web\View::POS_END);
     ?>          