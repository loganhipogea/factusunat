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

class Moneda extends \yii\base\Component 
{
  private $_key=null;
  private  $_data=[];
  private $_tableName='{{%monedas}}';
  private $_cache=null;
  private $_current_money=null;
  
  
  private function cache(){
      if(is_null($this->_cache)){
          $this->_cache=yii::$app->cache;
      }
      return $this->_cache;
  }
  
  private function keyCache(){
      return yii::$app->name.'moneda_cache';
  }
 
  public function setCache($array_cache_moneda){
      $this->cache()->set($this->keyCache(),$array_cache_moneda);
      return $this;
  }
  public function removeCache($array_cache_moneda){
      $this->cache()->delete($this->keyCache());
       return $this;
  }
  
  
  
  private function arrayMoneda(){
      //if(is_null($codmon))$codmon=$this->currentMoney;
      $rows= (new \yii\db\Query())->select('*')
               ->from($this->_tableName)->where(['codmon'=>$this->currentMoneyInCache])
               ->all();
      if(count($rows)>0)return $rows[0];
      return null;
  }
  
  private function existsInCache(){
     return $this->cache()->exists($this->keyCache());
  }
  
  public function getCurrentMoneyInCache(){
     if(is_null($this->_current_money)){
          $this->_current_money=yii::$app->settings->get('general','moneda');
      }
      return $this->_current_money;
  }
  
  public function setCurrentMoneyInCache($codmon){ 
      $this->_current_money=$codmon;
      return $this;
  }
  /*
   * DEUELVE EL REGISTRO DE LA MONEDA EN CUESTION
   */
  public function getMoney(){     
     if($this->existsInCache()){
         return $this->cache()->get($this->keyCache());
     }else{
        return $this->resolveCache();
     }
  }
  
  private function resolveCache(){
      $arrayMoney=$this->arrayMoneda();
      $this->setCache($arrayMoney);
      return $arrayMoney;
      
  }
  
  
}