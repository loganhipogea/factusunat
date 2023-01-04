<?php
namespace frontend\modules\com\components;
//use frontend\modules\com\models\UserFacultades;
//use frontend\modules\sta\staModule;
use common\helpers\h;
/* 
 * Esta clase es la que efectua los filtros por facultad segun 
 *
 */
class ActiveQueryCotiHijo extends \yii\db\ActiveQuery 
{
  public function init()
    {
      //var_dump(UserFacultades::filterFacultades());die();
       //$this->andWhere([ 'in', 'codfac',['FIM','FIP'] ]);
      if(!h::user()->isGuest){
         $this->alias('t')->andWhere([
            '>', 'detcoti_id',0
               ]);  
      }else{
          $this->alias('t');
      }
     
        parent::init();
    }
    
  
}

