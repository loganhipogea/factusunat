<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
use dosamigos\chartjs\ChartJs;
?>
<div class="site-index">

    <div class="body-content">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
     <H4><i class="fa fa-cogs"></i><?=yii::t('app','Módulos'); ?></H4>
 
          <div class="row">
        <!---Income-->
         <div class="col-12 col-sm-6 col-md-3">  
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >Config.</h3></div> 
               <div class="panel-body">
          <a href="<?=\yii\helpers\Url::to(["/sta/default/panel-coord",'codfac'=>'FIA'])  ?>"><span class="info-box-icon bg-yellow-gradient">
                  <i class="fa fa-cogs" style="color:#d392e8;font-size:4em;"></i></span>
          </a>
           </div> 
               </div> 
        </div> 
        
        
       <div class="col-12 col-sm-6 col-md-3">  
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >Ventas</h3></div> 
               <div class="panel-body">
          <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIA'])  ?>"><span class="info-box-icon bg-green-gradient">
                  <i class="fa fa-money" style="color:#f5c571;font-size:4em;"></i></span>
          </a>
           </div> 
               </div> 
        </div> 
       <div class="col-12 col-sm-6 col-md-3"> 
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >Almacén</h3></div> 
               <div class="panel-body">
            <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FAUA'])  ?>"><span class="info-box-icon bg-aqua">
                    <i class="fa fa-industry" style="color:#78ceff;font-size:4em;"></i></span>
            </a>
       </div> 
        </div> 
        </div>
        
        
       <div class="col-12 col-sm-6 col-md-3"> 
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >Compras</h3></div> 
               <div class="panel-body">
               <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIQT'])  ?>"><span class="info-box-icon bg-orange-active">
                       <i class="fa fa-cart-plus" style="color:#a5df85;font-size:4em;">
                           
                       </i>
                   </span>
               </a>
       </div> 
        </div> 
        </div>
        
        
        
            
    </div>
        <div class="row">
           <?= ChartJs::widget([
            'type' => 'line',
                'options' => [
                 'height' => 200,
                'width' => 400,
                     'lineTension'=> 0.3,
                    
                   
                'plugins'=> [
                        'filler'=> [
                            'propagate'=>false,
                                ]
                            ],
            'interaction'=>[
                    'intersect'=> false,
                    ],
                ],
        'data' => [
        'labels' => ["Enero", "Febrero", "Marzo", "April", "May", "June",],
        'datasets' => [
            [
                'label' => "Compras (S/.x 1,000)",
                'backgroundColor' => "rgba(179,181,198,0.2)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [6.5, 5.9, 9.0, 8.1, 5.6, 5.5]
            ],
            [
                'label' => "Ventas (S/.x 1,000)",
                'backgroundColor' => "rgba(255,99,132,0.2)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => [2.8, 4.8, 4.0, 1.9, 9.6, 2.7]
                    ]
                ]
            ]
                ]);
            ?>
        </div>
     </diV> 
       

    </div>
</div>
