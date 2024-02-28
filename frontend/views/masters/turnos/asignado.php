<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;
//use kartik\tabs\TabsX;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Ver asignado: {name}', [
    'name' => $model->nombres,
]);
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Asignados'), 'url' => ['asigna-turno','id'=>$model->idturno]];


?>
<div class="turnos-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>   
    <div class="box box-success">
    
    <?php  Pjax::begin(['id'=>'cabecera','timeout'=>false])   ?> 
        <table class="table table-hover">
        <tr><!-- El area-->
            <td><!-- comment -->
            <?=yii::t('base.names','Area').':'?>
            </td>
            <td><!-- comment -->
            <?=$model->codarea.'  - '.$model->desarea?>
            </td>
        </tr><!-- comment -->
        <tr>
            <td><!-- comment -->
            <?=yii::t('base.names','Grupo trabajo').':'?>
            </td>
            <td><!-- comment -->
            <?=$model->codcuadrilla.'  - '.$model->descricuadrilla?>
            </td>
        </tr><!-- comment -->
        <tr>
            <td><!-- comment -->
            <?=yii::t('base.names','Turno').':'?>
            </td>
            <td><!-- comment -->
            <?=$model->desturno?>
            </td>
        </tr><!-- comment -->
        <tr>
            <td><!-- comment -->
            <?=yii::t('base.names','Desde').':'?>
            </td>
            <td><!-- comment -->
            <?=$model->finicio?>
            </td>
        </tr><!-- comment -->
         <tr>
            <td><!-- comment -->
            <?=yii::t('base.names','Hasta').':'?>
            </td>
            <td><!-- comment -->
            <?=$model->fin?>
            </td>
        </tr><!-- comment -->
        <tr>
            <td><!-- comment -->
            <?=yii::t('base.names','Fecha de asignación').':'?>
            </td>
            <td><!-- comment -->
            <?=$model->fecha .'  '.$model->asignacion->antiguedad()?>
            </td>
        </tr><!-- comment -->
        <tr>
            <td><!-- comment -->
            <?=yii::t('base.names','Activo').':'?>
            </td>
            <td><!-- comment -->
            <?php if($model->asignacion->activo){ ?>
            <i style="font-size: 2em; color:#a9e272;"><span class="fa fa-check"></span></i>
            <?php }else{ ?>
            <i style="color:#fd250d; font-size:1.5em;" ><span class="fa fa-close"></i>
             <?php } ?>
            </td>
        </tr>
        <tr>
            <td><!-- comment -->
            <?=yii::t('base.names','Cambios o movimientos').':'?>
            </td>
            <td><!-- comment -->
            <div style="border-radius: 20px;
                        top: 60%;
                        padding: 1px;
                        right: 0;
                        width: 40px;
                        height: 40px;
                        background-color: #ff7500;
                        color: white;
                        font-size: 1.5em;
                        font-weight: bold;
                        text-align: center;
                        line-height: 36px;
                        -webkit-box-shadow: 1px 1px 8px -5px rgba(245,110,19,0.74);
-moz-box-shadow: 1px 1px 8px -5px rgba(245,110,19,0.74);
box-shadow: 1px 1px 8px -5px rgba(245,110,19,0.74);">
                <?=$model->asignacion->nPermisos()?>
            </div>
            
            </td>
        </tr>
        
        </table>
      <?php  Pjax::end();   ?>  
    </div>
    </div>


<?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('app','Movimientos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_asignado',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myverxxyownID3'],
        ],
       /* [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('app','Tutores'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],*/
       
        
       
    ],
]);  
?>