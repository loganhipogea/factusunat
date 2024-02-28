<?php

use console\migrations\baseMigration;

/**
 * Class m240213_134541_alter_turnoscambio_table
 */
class m240213_134541_alter_turnoscambio_table extends baseMigration
{ 
    public $table='{{%turnoscambio}}';
    private $_fields=[];
    
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
           'fcierre'=>$this->string(19), 
            'cerrado'=>$this->char(1), 
           // 'finicio'=>$this->string(19), 
            //'activo'=>$this->char(1),
              //'esemplazamiento'=>$this->char(1),  
      // 'cod_altern'=>$this->string(20),
            
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
      $this->deleteCombo($this->table, 'codestado') ; 
       
       
          
    }

   
}