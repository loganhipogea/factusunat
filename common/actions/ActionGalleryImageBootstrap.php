<?php
namespace common\actions;
use common\helpers\h;
use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionGalleryImageBootstrap extends \yii\base\Action
{
	
	public function run()
	{
          $this->controller->layout = "install";
        $clase=str_replace('_','\\',h::request()->get('nombreclase'));
        $id=h::request()->get('modelid');
          $model = $clase::find()->where(['id'=>$id])->one();
                if($model->hasAttachments()){
                    $items=[];
                   foreach($model->images as $image){
                       $items[]=['content'=>$image->url,
                                'caption'=>$image->titulo,
                                //'options'=>['title'=>(!empty($image->detalle))?$image->detalle:$image->titulo]
                               ];
                   }
       //var_dump($items);die();
            
            return $this->controller->renderAjax('/comunes/Gallery', [
                        'model' => $model,
                        'items'=>$items
                      
                 //'allowedExtensions' => $allowedExtensions,
                        //'vendorsForCombo' => $vendorsForCombo,
            ]);
          
          
                }else{
                    return "no tiene adjuntos"; 
                }
      }  
}