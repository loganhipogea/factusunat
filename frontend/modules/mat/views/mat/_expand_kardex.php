<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?> 



     <?php
     $zonaAjax='expand_kardex';
    // echo get_class($model);
     Pjax::begin(['id'=>$zonaAjax]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="btn-group">  
        <?php
        //$url= Url::to(['/masters/clipro/crea-almacen','id'=>$model->codcen,'gridName'=>$zonaAjax,'idModal'=>'buscarvalor']);
 
        ?>
        <?php //echo Html::a('<span class="fa fa-industry"></span>'.'  '.Yii::t('base.verbs', 'Create store'), $url, ['class' => 'btn btn-success botonAbre']) ?>
   
   
    <?php
    $dataProvider=new \yii\data\ActiveDataProvider([
                'query'=> \frontend\modules\mat\models\MatVwKardex::find()->andWhere(['codart'=>$model->codart,'codal'=>$model->codal]),
            ]);
  ?>
    </div>

    <?php ECHO GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        // 'summary' => '',
        //'tableOptions'=>['class'=>".thead-dark table table-condensed table-hover table-bordered table-striped"],
        'columns' => [
            'cant',
            'fecha',
            'despro',
            'desdocu',
             'numerodoc',
           
            //'deslarga:ntext',

              
        ],
    ]); ?>
    
    
   <?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgestgrurtryidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'clipropj',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>
    
