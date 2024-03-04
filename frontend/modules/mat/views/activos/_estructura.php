<?php
use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
use yii\helpers\Json;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\MaestrocompoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>


         <div class="btn-group">
          <?php
                    $url=Url::toRoute(['/mat/activos/modal-crea-nodo','id'=>-$model->id,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor',]);
            ?>
            <?php  
                    echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar raiz'), ['href' => $url, 'title' => '','id'=>'btn_adrtrtrteses',    'class' => 'botonAbre btn btn-danger']); 
                ?> 
            
        </div>




  <?php 
     Pjax::begin(['id'=>'grilla-arbol']);
     Pjax::end();
    ?>
   
       <div class="row">
        <div class="btn-group">
          <?php echo Html::input('text','hola','',['id'=>'cadena_a_buscar','class'=>'form-control']);  ?> 
          <?php echo Html::button('hola',['id'=>'busqueda','class'=>'btn-success']);  ?>  
            
        </div>
        
      </div>
    
   
        
        
       <?php  
       

  echo yii2mod\tree\Tree::widget([
    'items'=>$arr_arbol,   
     
       'clientOptions' =>[     
                            'extensions'=> ["filter"],
                            'filter'=>[  // override default settings
                                'counter'=>false, // No counter badges
                                'mode'=>"hide",  // "dimm": Grayout unmatched nodes, "hide": remove unmatched nodes
                                    //'checbox'=>true,
                                    ], 
                              
           
           
                            ]//client OPtions
     ]//Widget
     
     ); ?>
            </div>
     <?php    
    $js1='$(".fancytree-container").addClass("fancytree-connectors");';
    
     $this->registerJs($js1, \yii\web\View::POS_END);
     ?>  
   
    <?php    
    $js2='$("#tree").fancytree("getTree").setOption("checkbox", true);';    
     $this->registerJs($js2, \yii\web\View::POS_END);
     ?>          
    <?php    
    $js5='$("#tree").fancytree("getTree").setOption("select", function(event, data) {
                        // console.log(data["node"]["selected"]);   
                        
                                                                                }
                                                                        );';    
     $this->registerJs($js5, \yii\web\View::POS_END);
     ?>   
            
   <?php  
    $js4="$('#busqueda').on('click', function () {
         var cadena=$('#cadena_a_buscar').val();
        // alert(cadena);
         var tree = $('#tree').fancytree('getTree').filterNodes(cadena,
        {autoExpand: true, leavesOnly: false, counter:true ,hideExpandedCounter:false}
        );
        }
        );
        
        
        ";
     $this->registerJs($js4, \yii\web\View::POS_END);
     ?>  
            
            <br>
            <p> Agregados recientemente : </p>       
    <?= GridView::widget([
        'dataProvider' =>New \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\mat\models\MatDespiece::find()->orderBy(['creado'=>SORT_DESC])->limit(2),
            'pagination' => false,
        ]),
         'summary' => '',
       
       
        'columns' => [
           
              'codart',              
           ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->material->descripcion;
                              } 
                
                ], 
                        
                 'cant',          
                 'creado',           
              ['attribute' => 'USER',
                'format'=>'raw',
             
               // 'contentOptions'=>['style'=>'text-align:right; font-weight:800;'],
                'value'=>function($model) {
                        return '<span class="fa fa-user"></span>'.$model->username ;
                            } 
                
                ], 
          
        ],
    ]); ?>