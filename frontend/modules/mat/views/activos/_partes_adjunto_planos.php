<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
use yii\helpers\Json;
//use yii\grid\GridView;
use kartik\grid\GridView;

$this->title = Yii::t('base.names', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>
         <div class="btn-group">
          <?php
                    $url=Url::toRoute(['/prd/planos/modal-crea-plano','id'=>$model->id,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor',]);
            ?>
            <?php  
                    echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar plano'), ['href' => $url, 'title' => '','id'=>'btn_addplano',    'class' => 'botonAbre btn btn-danger']); 
                ?> 
            
        </div>
  <?php 
     Pjax::begin(['id'=>'grilla-arbol']);
    
    ?>
    <?php 
     $planos= \frontend\modules\prd\models\PrdPlanos::find()->andWhere(['matdespiece_id'=>$model->id])->all();
      
    ?>
    
<table class="table">
    <thead>
    <tr>
        <th scope="col"></th>
      <th scope="col">Descripción</th>
      <th scope="col">Revisión</th>
      <th scope="col">Fecha</th>
      <th scope="col">Estado</th>
    </tr>
  </thead>
            <?php 
                foreach($planos as $plano ){
            ?>
                <tr class="">
                    <td>
                       <?php 
                            $url= Url::to(['/prd/planos/modal-edita-plano','id'=>$plano->id,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor']);
                              
                            echo \yii\helpers\Html::a('<span class="btn  glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                           $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              echo \yii\helpers\Html::a('<span class="btn  glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                          
                       ?>
                   </td>
                   <td>
                    <?=$plano->descriplano?>
                   </td>
                    <td>
                        <p class="badge badge-warning"><?=$plano->revision?></p>
                   </td>
                    <td>
                        <?=$plano->fecha?>
                   </td>
                    <td>
                        <?=$plano->status?>
                   </td>
                </tr>
                        <!-- AQUI OTRO FOR PARA LAS REVISIOSNES -->
                      <?php  if($plano->hasRevisiones()) { ?>
                        <tr colspan="5">
                       <div class="row"> 
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
                          <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Cambio</th>
                                            <th scope="col">Rev</th>
                                            <th scope="col">Final</th>
                                            
                                        </tr>
                                    </thead>
                          <?php foreach($plano->revisiones as $revision ){ ?>
                                    <tr class="">
                                         <td>
                                                <?php 
                                                                $url= Url::to(['/prd/planos/modal-edita-plano','id'=>$model->id,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor']);
                              
                                                                 echo \yii\helpers\Html::a('<span class="btn  glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                                                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                                                                echo \yii\helpers\Html::a('<span class="btn  glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                          
                                                    ?>
                                            </td>
                                            <td>
                                                    <?=$revision->fecha?>
                                            </td>
                                            <td>
                                                    <?=$revision->cambio?>
                                            </td>
                                            <td>
                                                    <p class="badge badge-warning"><?=$revision->rev?></p>
                                            </td>
                                            
                                            <td>
                                                <input type="checkbox" checked=" <?=$revision->final?>">
                                            </td>
                                        </tr>
                            
                             <?php  }?>
                           </table> 
                         </div> 
                        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12"> 
                            hola 
                        </div> 
                       </div> 
                        </tr>
                       <?php  }?> 
                
                <?php 
                    }
                ?>
</table>


  
      


   
   <p> Agregados recientemente : </p>       
    <?= GridView::widget([
        'dataProvider' =>New \yii\data\ActiveDataProvider([
            'query'=> \frontend\modules\prd\models\PrdPlanos::find()->andWhere(['matdespiece_id'=>$model->id])->orderBy(['fecha'=>SORT_DESC]),
            'pagination' => false,
        ]),
         'summary' => '',
       
       
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    
                                
                                'edit' => function ($url,$model)   {
			    $url= Url::to(['/prd/planos/modal-edita-plano','id'=>$model->id,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor']);
                              
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                               
			   $url = \yii\helpers\Url::to([$this->context->id.'/ajax-desactiva-item','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
              'expandIcon'=>'<i style="color:#fcc400"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#fcc400"><span class="fa fa-minus-square-o"></span></i>',
                
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                                        
                     'detail'=>function ($model, $key, $index, $column){
                                    
                         
                        return  $this->render('_expand_revisiones_plano',[
                            'id'=>$model->id,
                            'model'=>$model,
                            ]);            
                     },
                                       
                     //'detailUrl' =>Url::toRoute(['/op/proc/ajax-expand-opera']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 
              'codart',  
              ['attribute' => 'status',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->status;
                              } 
                
                ], 
           ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->material->descripcion;
                              } 
                
                ], 
                  'descriplano',      
                 'fecha',          
                 'revision',           
               'codigo', 
          
        ],
    ]); ?>

   
   
    
   
    <?php 
    
     Pjax::end();
    ?>

    