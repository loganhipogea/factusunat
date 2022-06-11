<?php
namespace console\migrations;
use yii\db\Migration;
use backend\components\Installer;
//use common\models\masters\ModelCombo; //la tabla de combos padre config
use common\models\masters\Combovalores;
/*
 * Clase definida para ayudar asimplificar los procesos de migracion 
 * valido solo para MYSQL
 * uSELA Y VERA COMO LE SIMPLKIFICA LA VIDA 
 */
class baseMigration extends Migration
{
    private $_tabla='{{%fks}}';
    public $paramsFk=[];
    
    const TABLE_COMBO='{{%combovalores}}' ;
    public function isMySql(){
        return ($this->db->driverName === 'mysql')?true:false;
            
    }
    
    public function getCollate(){ 
        return trim(Installer::readEnv('DB_COLLATE', 'utf8_unicode_ci'));
    }
    
    public function getCharacterSet(){ 
        return trim(Installer::readEnv('DB_CHARSET', 'utf8'));
       }

    
    public function getDbEngine(){ 
       return trim(Installer::readEnv('DB_ENGINE', 'InnoDB'));
         }
    
         
    public function collateTable(){
        if($this->isMySql())
        return "CHARACTER SET '".$this->getCharacterSet()."' COLLATE '".$this->getCollate()."' ENGINE=".$this->getDbEngine()." "  ;
        return "";
    }
    
    public function collateColumn(){
        return " COLLATE '".$this->getCollate()."'";
    }
    
  
   public function existsFk($table,$nameFk)
    {
      if($this->existsTable($table)){
           $fks= array_keys($this->getTable($table)->foreignKeys);
         return (in_array($nameFk,$fks))?true:false;
      }else{
         throw new \yii\base\Exception(yii::t('base.errors',' Table \'{tabla}\' doesn\'t exists  ',['tabla'=>$table]));      
         
      }
        
    }
  
    public function existsTable($table){
       if($this->getTable($table,true)===null){
           return false;
       }else{
           return true;
       }
    }
  
    public function existsColumn($table,$column){
       
       if($this->existsTable($table)){ 
           $table=$this->getTable($table);
          if(!is_null($table->getColumn($column)))
              return true;
           return false;
       }else{
           return false;
       }
    }
  
    
    
  
    public function dropFks($table)
    {
      if($this->existsTable($table)){
           $fks= array_keys($this->getTable($table)->foreignKeys);
        foreach($fks as $clave=>$nombreFk){
            $this->dropForeignKey($nombreFk, $table);
        }
      }else{
         throw new \yii\base\Exception(yii::t('base.errors',' Table \'{tabla}\' doesn\'t exists  ',['tabla'=>$table]));      
         
      }
        
    }     
            /*genera un unico nomrbe a una clave ajemna*/
    public function generateNameFk($tablex){
        //if($tablex===null or $tablex=='')
            //$tablex='unk';
       // $tablex=preg_match("[^A-Za-z0-9]", "", $tablex);
        $val='fk_'.Installer::generateRandomString(16);
         //$val= preg_match("[^A-Za-z0-9]", "", $val);
        return $val;
    }   
    
    /*Esta funcion registra los valores clave de los cmpos en la tabla comoo valores 
     * por ejemplo  
     *   codestado=> 100=>CREADO, 200=>ANULADO .etc 
     */
    public function putCombo($table,$namefield,$valor){
       
        $tableSchema=$this->getTable($table);
       $campos=$tableSchema->columns;
       $realNameTable=str_replace($this->getPrefix(),'',$tableSchema->name);
       $largo=$campos[$namefield]->size;unset($campos);
       $valor=(is_array($valor))?$valor:[$valor];
       foreach($valor as $key=>$val){
          if(!self::fillCboValor($key, $realNameTable, $namefield, $val,  $largo))
            break;
       }
      
        
        
    }
  
    private static function fillCboValor($i,$realNameTable,$namefield,$valor,$largo){
       
        if($largo==1){
              if($valor=='Z'){
                  return false;
              }else {
                  $code=self::selectLetter($i);  
                  return true;
                  
              }
        }else{
            $code='1'.str_pad($i, $largo-1, '0', STR_PAD_LEFT);
           /*ModelCombo::firstOrCreateStatic([
            'parametro'=>$realNameTable.'.'.$namefield,
            'clavecentro'=>'0',
            ]);*/
            Combovalores::firstOrCreateStatic([
            'nombretabla'=>$realNameTable.'.'.$namefield,
            'codigo'=>$code,
             'valor'=>$valor,
            ]);
          return true;
        }
        
       
    }
    private static function selectLetter($i){
       $letras='ABCDEFGHIJKLMNOPQRSTUWXYZ';
       return substr($letras, $i, 1);
    }
    
    public function deleteCombo($table,$namefield){
        $tableSchema=$this->getTable($table);
        
       $campo=str_replace($this->getPrefix(),'',$tableSchema->name).'.'.$namefield;
       unset($tableSchema);
        
        (new \yii\db\Query)
    ->createCommand()
    ->delete(self::TABLE_COMBO,"nombretabla=:valor",[":valor"=>$campo])
    ->execute();
    }
     
    
    private function getTable($table,$refresh=false){
     return $this->getDb()->getSchema()->getTableSchema($table,$refresh);   
    }
    
    public function getPrefix(){
     return $this->getDb()->tablePrefix;   
    }
    
    public function dropView($nameView){
        $this->db->createCommand()->dropView($nameView)->execute();
    }
    public function nameFk(){
        $namecolumns='';
        $namerefcolums='';
            if(is_array($this->paramsFk[1])) {
                    foreach($this->paramsFk[1] as $column){
                        $namecolumns.=$column;
                        }
                   }else{
                        $namecolumns.=$this->paramsFk[1];
               }
           if(is_array($this->paramsFk[3])) {
                    foreach($this->paramsFk[3] as $column){
                        $namerefcolums.=$column;
                        }
                   }else{
                        $namerefcolums.=$this->paramsFk[3];
               }
             return 'fk_'.preg_replace('([^A-Za-z0-9_])', '', $this->paramsFk[0]).'_'.$namecolumns.'_'.preg_replace('([^A-Za-z0-9_])', '', $this->paramsFk[2]).'_'. $namerefcolums;      
         }
    /*public function addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null) {
        $name=$this->nameFk($table, $columns, $refTable, $refColumns);
        try {
            parent::addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update); 
        } catch (Exception $ex) {
            $this->storeFk($name, $table, $columns, $refTable, $refColumns,$ex->getMessage());
        }
       
    }*/
    private function storeLogFk($error){
        $this->db->createCommand()->insert($this->_tabla, [
            'name'=>$this->nameFk(),
            'tabla_origen'=>$this->paramsFk[0],
            'campo_origen'=>(is_array($this->paramsFk[1]))?\yii\helpers\Json::encode($this->paramsFk[1]):$this->paramsFk[1],
            'tabla_destino'=>$this->paramsFk[2],
             'campo_destino'=>(is_array($this->paramsFk[3]))?\yii\helpers\Json::encode($this->paramsFk[3]):$this->paramsFk[3],
              'exito'=>'0',
              'error'=>$error,
        ])->execute();
    }
    private function deleteLogFk(){
        $this->db->createCommand()->delete('{{%fks}}',                
                [
                    'name'=>$this->nameFk(),
                    
                    ]
                )->execute();
        
    }
   public function addFk(){
       try{
           $this->addForeignKey(
                   $this->nameFk(),
                   $this->paramsFk[0], $this->paramsFk[1], $this->paramsFk[2], $this->paramsFk[3]
                   );
       } catch (Exception $ex) {
           $this->storeLogFk($ex->getMessage());
       }
       
   }
   
   public function dropFk(){
       
           $this->dropForeignKey(
                   $this->nameFk(),
                   $this->paramsFk[0]
                   );
           $this->deleteLogFk();
       } 
       
   }
            

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

