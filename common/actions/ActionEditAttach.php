<?php
namespace common\actions;
use common\helpers\h;
use common\models\File;
use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionEditAttach extends \yii\base\Action
{
	
	public function run()
	{
             $this->controller->layout = "install";
         
           $model=File::findOne(h::request()->get('id'));
            $grillas=h::request()->get('grillas');
         
         
        if (h::request()->isPost ) {
            
           $post=h::request()->post();
           
           $model->titulo=$post['File']['titulo'];
            $model->detalle=$post['File']['detalle'];
           $model->codocu=$post['File']['codocu'];
           $grillas=$post['grillas'];
           $model->save();
             $this->controller->closeModal('buscarvalor',$grillas);
         
        } else {
           
           yii::error('Renderizando la vista  ');
            return $this->controller->render('/comunes/editAttach', [
                        'model' => $model,
                        'grillas'=>$grillas,
                 //'allowedExtensions' => $allowedExtensions,
                        //'vendorsForCombo' => $vendorsForCombo,
            ]);
        }
          

             }
}