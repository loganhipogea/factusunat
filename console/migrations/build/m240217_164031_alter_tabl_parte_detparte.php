<?php

use console\migrations\baseMigration;

/**
 * Class m240217_164031_alter_tabl_parte_detparte
 */
class m240217_164031_alter_tabl_parte_detparte extends baseMigration
{
    public $table='{{%op_tareo}}';
    private $_fields=[];
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
           'codsoc'=>$this->char(1), 
            'codcen'=>$this->string(5), 
           'codarea'=>$this->string(14), 
           'turno_id'=>$this->integer(11), 
           
        ];
        
       }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
       
        foreach($this->getFieldsTomodify() as $campo=>$columna){
           if(!$this->existsColumn($this->table,$campo)){  
            $this->addColumn($this->table,$campo,$columna); 
             } 
        }
        
        $this->table='{{%op_tareodet}}';
        foreach($this->getFieldsTomodify() as $campo=>$columna){
           if(!$this->existsColumn($this->table,$campo)){  
            $this->addColumn($this->table,$campo,$columna); 
             } 
        }
      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->table='{{%op_partedet}}'; 
       foreach($this->getFieldsTomodify() as $campo=>$columna){
           if($this->existsColumn($this->table,$campo)){  
            $this->dropColumn($this->table,$campo); 
             } 
        } 
        
         $this->table='{{%op_parte}}'; 
      foreach($this->getFieldsTomodify() as $campo=>$columna){
           if($this->existsColumn($this->table,$campo)){  
            $this->dropColumn($this->table,$campo); 
             } 
        } 
       
       
          
    }

   
}