<?php

use console\migrations\baseMigration;

/**
 * Class m240203_155751_altertable_opdespice
 */
class m240203_155751_altertable_opdespice extends baseMigration
{
    
    public $table='{{%op_osdespiece}}';
    private $_fields=[];
    
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
         'codart'=>$this->string(14)->append($this->collateColumn()),
         'descripcion'=>$this->string(80)->append($this->collateColumn()),
            'serie'=>$this->string(80)->append($this->collateColumn()),
          
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
        
      
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       foreach($this->getFieldsTomodify() as $campo=>$columna){
           if($this->existsColumn($this->table,$campo)){  
            $this->dropColumn($this->table,$campo); 
             } 
        } 
      
       
          
    }
}