<?php

use yii\helpers\Html;
use yii\grid\GridView;
USE yii\widgets\Pjax;
use frontend\modules\logi\models\LogiVwStock;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>


    
    <div style='overflow:auto;'>
    <?php yii::error(\common\models\masters\Maestrocompo::find()->
            andFilterWhere(['like', 'descripcion', $parametro])-> 
        createCommand()->rawSql,__FUNCTION__);            
                    $likeCondition = new \yii\db\conditions\LikeCondition('descripcion', 'LIKE','%'.$parametro.'%');
                    $likeCondition->setEscapingReplacements(['%'=>'%']);
                
            ?>
    <?php Pjax::begin(['id'=>'stock-index']); ?>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
                'query'=> \common\models\masters\Maestrocompo::find()->andWhere($expression),
                'pagination'=>['pageSize'=>10],
                ]),
         'summary' => '',
        
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       'columns' => [
         [
               'class' => 'yii\grid\ActionColumn',
                'template' => '{add}',
                'buttons' => [
                    /*'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options);
                         },*/
                         'add' => function($url, $model)use($idpet) {
                             if($idpet>0){
                                 $url= \yii\helpers\Url::toRoute(['/mat/petoferta/ajax-add-item','id'=>$model->id]);
                                $options = [
                                'rel' => $url,
                                 'family'=>'holas',
                                  'id'=>$model->id,                                 
                               ]; 
                             }else{
                                $url= \yii\helpers\Url::toRoute(['/mat/mat/ajax-add-art','id'=>$model->id]);
                              $options = [
                               //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                                 'title' => $url,
                                 'family'=>'holas',
                                 
                               ];
                             }
                              
                                 return Html::a('<span class="btn btn-success btn-sm glyphicon glyphicon-plus"></span>','#', $options);
                         }
                    ]
                ],
            ['attribute'=>'codart',
                 //'contentOptions' => ['style' => 'width:80px;'],
               'headerOptions' => ['style' => 'width:10%'],
                  'value'=>function ($model){
                    return $model->codart;
                  }
                ],
            ['attribute'=>'descripcion',
                 //'contentOptions' => ['style' => 'width:80px;'],
               'headerOptions' => ['style' => 'width:70%'],
                  'value'=>function ($model){
                    return $model->descripcion;
                  }
                ],
             
            ['attribute'=>'codum',
                 //'contentOptions' => ['style' => 'width:80px;'],
                'headerOptions' => ['style' => 'width:10%'],
                  'value'=>function ($model){
                    return $model->codum;
                  }
                ],                    
           // 'pventa',
           /*['attribute'=>'agre',
                'header'=>'+',
                'format'=>'raw',
                  'contentOptions' => ['style' => 'width:10px;'],
               // 'headerOptions' => ['style' => 'width:30%'],
                  'value'=>function ($model){
                    return '<div id="'.$model->id.'_stock_grilla" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i></div>';
                  }
                ], */
           
        ],
    ]); ?>
 
        <?php 
     if($idpet > 0){
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
        'otherContainers'=>['pjax-detpet'],
            'idGrilla'=>'stock-index',
            'family'=>'holas',
            'data'=>['idpet'=>$idpet],
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
        
     }else{
       
        $cadenaJs="$('div[id=\"stock-index\"] [family=\"holas\"]').on( 'click', function() { 
                   console.log('probando');
                    console.log('El id:');
                    console.log(this.id);
                    $.ajax({
                            url: this.title,              
                            type: 'POST',                           
                            data:{valorInput:this.id},
                            dataType: 'html',                                              
                                success: function(data) { 
                                        var_fila=JSON.parse(data);
                                       console.log(var_fila);
                                       console.log(var_fila[0]['codart']);
                                       v_fila=var_fila[0];
                                       console.log($('div[class*=\"js-input-plus\"]').length);
                                        console.log($('div[class*=\"js-input-plus\"]').attr('class'));
                                        //$('div[class*=\"js-input-plus\"]').css('background-color','red');
                                        $('div[class*=\"js-input-plus\"]').trigger('click');
                                        
                                             //hallando el mayor indice
                                             v_maximo=0;
                                             console.log('Recorriendo el bucle:');
                                            $('#monet').find('input[name*=\"[pventa]\"]').each(function(){
                                                            var_index=$(this).parent().parent().parent().attr('data-index'); 
                                                             console.log($(this).attr('name'));
                                                             console.log('el var_index :');
                                                              console.log(var_index);
                                                                    if(v_maximo < var_index ){
                                                                    v_maximo=var_index
                                                                    } //fin de if
                                                     
                                                                });//fin del each  
                                              console.log('Fin del bucle:');
                                              console.log('el maximo id es :');
                                              console.log(v_maximo);
                                              console.log('#matdetpetoferta-'+v_maximo+'-'+'codart');
                                              $('#matdetpetoferta-'+v_maximo+'-'+'descripcion').val(v_fila['descripcion']);
                                              $('#matdetpetoferta-'+v_maximo+'-'+'cant').val(1);
                                               $('#matdetpetoferta-'+v_maximo+'-'+'pventa').val(v_fila['pvental']);
                                               $('#matdetpetoferta-'+v_maximo+'-'+'codart').val(v_fila['codart']);
                                              
                                     }//fin del success
                        });
                        })";
  
   $this->registerJs($cadenaJs, \yii\web\View::POS_END); 
     }    
               
  ?>
      
        
     <?php Pjax::end(); ?>
   
</div>
    
       