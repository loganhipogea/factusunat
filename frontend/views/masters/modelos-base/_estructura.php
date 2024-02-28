<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\MaestrocompoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>






  
  <?php 
     Pjax::begin(['id'=>'grilla-arbol']);
     Pjax::end();
    ?>
    <div class="box">
       <div class="row">
        <div class="btn-group">
          <?php
                    $url=Url::toRoute(['masters/modelos-base/modal-crea-nodo','id'=>-$model->id,'gridName'=>'grilla-arbol','idModal'=>'buscarvalor',]);
            ?>
            <?php  
                    echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar raiz'), ['href' => $url, 'title' => '','id'=>'btn_adrtrtrteses',    'class' => 'botonAbre btn btn-danger']); 
                ?> 
            
        </div>
        
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


           
     <?php    

     ?>  
   
    <?php    
  
     ?>          
    <?php    

     ?>   
            
   




