<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use kartik\grid\GridView as grid;
  use common\models\masters\Clipro;
use common\models\masters\Direcciones;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
?>


     <?php Pjax::begin(['id'=>'grilla-trabajadores','timeout'=>false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <?php
   $gridColumns=[
       
           
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['masters/clipro/edit-direccion','id'=>$model->id,'gridName'=>'grilla-direcciones','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class=" danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
              
                ],
           [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'nombres',
           
            
         ],
       
   ];
           
   echo GridView::widget([
    'dataProvider'=> new yii\data\ActiveDataProvider(
                [
                    'query'=> \common\models\masters\VwCuadrillas::find()->
                select(['nombres'])
                ->andWhere(['idcuadrilla'=>$model->id])
                ]),
   // 'filterModel' => $searchModel,
    'columns' => $gridColumns,
      // 'summary'=>'',
    //'responsive'=>true,
    //'hover'=>true
       ]);
   ?>
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widget6768gruidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'grilla-direcciones',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>
   <?php Pjax::end(); ?>
     <?php $url=Url::toRoute(['masters/cuadrillas/modal-agrega-trabajador','id'=>$model->id,'gridName'=>'grilla-trabajadores','idModal'=>'buscarvalor',]);   ?>
   <?php  
     echo  Html::button('<span class="fa fa-user"></span>'.yii::t('base.verbs','Agregar trabajador'), ['href' => $url, 'title' => '','id'=>'btn_adrtrtrteses',    'class' => 'botonAbre btn btn-success']); 
  // echo  Html::button(yii::t('base.verbs','Createx'), ['href' => $url, 'title' => 'Nueva direccion de '.$model->despro,'id'=>'btn_ad3435dresses', 'class' => 'botonAbre btn btn-success']); ?>
    

   
    


     
      












 
</div>   