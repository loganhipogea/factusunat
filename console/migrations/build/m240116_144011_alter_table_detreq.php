<?php

use console\migrations\baseMigration;

/**
 * Class m240116_144011_alter_table_detreq
 */
class m240116_144011_alter_table_detreq extends baseMigration
{
    public $table='{{%mat_detreq}}';
   private $_fields=[];
    
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
         'ruta'=>$this->text(),
         'ruta_larga'=>$this->text(),
            'parent_id'=>$this->integer(11),
       'clave'=>$this->string(20),
            'op_id'=>$this->integer(11),
            
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