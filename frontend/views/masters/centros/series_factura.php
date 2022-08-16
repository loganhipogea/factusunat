<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
use frontend\modules\com\modelBase\ComSeriesFactura;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\com\ComOvSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
      $zonaAjax='lista-series'.$model->codcen;
        Pjax::begin(['id'=>$zonaAjax]); 
    
    echo GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
                        'query'=> ComSeriesFactura::find()
                        ->andWhere(['codcen'=>$model->codcen])
                        ]),
        'columns' => [
           
            'serie',
            [
                'attribute' => 'tipodoc',
                'value'=>function($model){
                    return h::sunat()->graw('s.01.tdoc')->combo()->data[$model->tipodoc];
                }
                
            ],
           
            [
                'class' => ActionColumn::className(),
                 'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model)use($zonaAjax) {
			    $url= Url::to(['/com/com/modal-edit-serie','id'=>$model->id,'gridName'=>$zonaAjax,'idModal'=>'buscarvalor']);
                              return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function  ($url,$model)use($zonaAjax) {                             
                                $url = Url::to([$this->context->id.'/ajax-delete-model','id'=>$model->id]);
                              return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', 'javascript:void()', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->codcen,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
         <?php 
        $url= Url::to(['/com/com/modal-create-serie','codcen'=>$model->codcen,'gridName'=>$zonaAjax,'idModal'=>'buscarvalor']);
             echo  Html::button('<span class="fa fa-ticket"></span>'.yii::t('base.verbs','Crear Serie'), ['href' => $url, 'title' => 'Nueva serie ','id'=>'btn_contacts','gridName'=>$zonaAjax,    'class' => 'botonAbre btn btn-success']); 
         ?>
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>$zonaAjax,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>

</div>
