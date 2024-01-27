<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\MaestrocompoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>





   <h4><?=h::awe('dropbox')?><?= Html::encode($this->title) ?></h4>
  <?php 
     Pjax::begin(['id'=>'grilla-arbol']);
     Pjax::end();
    ?>
    <div class="box">
       <?php  
       

 echo yii2mod\tree\Tree::widget([
    'items'=>$arr_arbol,                  
            'clientOptions' => [
                //'autoCollapse' => true,
                'lazyLoad'=>new \yii\web\JsExpression('
                    function(event, data) {
                 var node = data.node;
               var paragraph =data.node.tooltip;
              // alert(data.node.tooltip);
                        var searchTerm = "_";
                      var indexOfFirst = paragraph.indexOf(searchTerm);
                        var indice=paragraph.substr(indexOfFirst+1);
                         var controlador=paragraph.substr(0,indexOfFirst);
                        // alert(indice);
                        // alert(controlador);
                        var myUrl="'.\yii\helpers\Url::toRoute([$this->context->id.'/']).'";
                           myUrl=myUrl+"/"+controlador;
                         //  alert(myUrl);
                // Issue an Ajax request to load child nodes
                     data.result = {                      
                        url:"'.\yii\helpers\Url::toRoute([$this->context->id.'/fill-items-tree-estr']).'",
                    data: {key: node.key}
                    }
                    }'),
                'clickFolderMode' => 3,
                /*'click'=>new \yii\web\JsExpression('
                    function(event, data){
                                     alert(data.node.tooltip);
                                        }'),                
    */
                'activate' => new \yii\web\JsExpression('
                        function(node, data) {
                              node  = data.node;
                              // Log node title
                              console.log(node.title);
                        }
                '),
            ],
        ]); ?>
    <?php    
    $js='$(".fancytree-container").addClass("fancytree-connectors");';
     $this->registerJs($js, \yii\web\View::POS_END);
     ?>   
        
            </div>
