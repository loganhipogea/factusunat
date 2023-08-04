<?php

namespace frontend\modules\mat\behaviors;
use yii\base\Behavior;
use frontend\modules\mat\models\MatReserva;
use yii;

/*
 * Esta permite generar documentos de reserva
 * de materiales 
 * 
 */

class ReservaBehavior extends Behavior {
    
    
   
    
    public function findReserva(){
      return  MatReserva::findOne([
            'numdocref'=>$this->owner->numero,
            'codocuref'=>$this->owner->codocu(),
            ]);
    }
    
    public function createReserva(){
        $model=New MatReserva();
        $model->setAttributes([
            'fecha'=>MatReserva::currentDateInFormat(),
            'codocuref'=>$this->owner->codocu(),
            'numdocref'=>$this->owner->numero,
            
        ]);
       $model->save();
       $model->refresh();
      
       return $model;
    }
    
    public function reserva(){
       
       if(is_null($modelReserva=$this->findReserva())){
           
           return $this->createReserva();
       }else{
           return $modelReserva;
       }
        
    }
    
    
   
    
}
