<?php

use console\migrations\baseMigration;

/**
 * Class m240228_211100_alter_matdespiece
 */
class m240228_211100_alter_matdespiece extends baseMigration
{
    private $_fields=[];
    public $table='{{%mat_despiece}}';
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
           'status'=>$this->string(40)->comment("Estado con el sigiente foramto  APR\AB\EC"), 
             'current_status'=>$this->string(4)->comment("Estado actual puede ser ap, rec, dis"), 
           'creado'=>$this->string(19), 
           'username'=>$this->string(40), 
           // 'tipo'=>$this->char(1), 
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
      
       
       
          
    }

   
}