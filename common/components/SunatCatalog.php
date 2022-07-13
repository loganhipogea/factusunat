<?php

namespace common\components;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SunatCatalog extends ComboCatalog
{
    
  public function g($key_word){  
      
       $arr=array_combine(
               array_column($this->data,'valor1'),
               array_column($this->data,'codigo')
               );
       
       return (array_key_exists($key_word,$arr))?$arr[$key_word]:null;
        
      }    
  
}