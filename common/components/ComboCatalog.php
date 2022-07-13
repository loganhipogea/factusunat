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

class ComboCatalog extends \yii\base\Component 
{
  private $_key=null;
  private  $_data=[];
  
  public function getKey(){      
          return $this->_key;     
  }
  
  public function getData(){      
          return $this->_data;     
  }
  public function setData($data){      
          $this->_data=$data;
          return $this;
  }
  
  public function setKey($param){      
           $this->_key=$param;
     return $this;
  }
  
  /*
   * Retorna un array de filas de valores
   * [
   *  ['codigo'=>'100','valor'=>'IGV'],
   *  ['codigo'=>'200','valor'=>'SC'],
   *  ['codigo'=>'300','valor'=>'LLAVR'],
   * ]
   */
   public function gRaw($param){
      
       //$this->clearCache(); die();
       $this->setKey($param);       
       $cache=\yii::$app->cache;
       
        if($cache->exists($this->key)){
            
            //echo "El cache no se limpio"; $this->clearCache();die();
            //var_dump($cache->get($this->key));die();
            
            $this->setData($cache->get($this->key));
        }else{
            //yii::error('el cache si existe '.$this->key);
            $cache=\yii::$app->cache;
            //yii::error('XXasignando  DATA AL ARRAY DE CONSULTA');
            // yii::error('EL ARRAY de consulta  ES ');yii::error($this->queryKey());
            $this->setData($this->queryKey());
            //yii::error('Ahora colocando este valor data en el cache ');
            $cache->set($this->key, $this->data,60*60*500);
            }
       return $this;
      }
   /*
   * Retorna un array de filas de valores lista para un combo
   * 
   *  [
    * '100'=>'IMPUESTO G VENTAS',
   *  '200'=>'IMPUESTO SELCTIVO AL CONSUMOP',
   *  '300'=>'LLAVR'
    * ],
   * 
   */
   public function combo(){
       $arreglo=$this->data;       
       $this->setData(array_combine(
       array_column($arreglo,'codigo'),
        array_column($arreglo,'valor'),       
               ));
       return $this;
      } 
   
  public function getText($code){  
      
       $arr=array_combine(               
               array_column($this->data,'codigo'),
               array_column($this->data,'valor'),
               );
       
       return (array_key_exists($code,$arr))?$arr[$code]:null;
        
      }     
  private function  queryKey(){
    $rows= (new Query())
            ->select(['codigo','valor','valor1'])->from('{{%combovalores}}')->where([
        'nombretabla'=>$this->key
            ])->all();
      
     return $rows;
  }
 public function clearCache(){
     //yii::$app->cache->flush();
    return  \yii::$app->cache->delete($this->key);
 } 
  
}