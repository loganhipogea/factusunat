<?php

use console\migrations\baseMigration;

/**
 * Class m240226_205534_alter_table_activos
 */
class m240226_205534_alter_table_activos extends baseMigration
{

    private $_fields=[];
    public $table='{{%mat_activos}}';
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
           'codigo_alterno2'=>$this->string(20)->comment(' codificaion algternativa'),
           'aniofab'=>$this->string(4), 
            'fecha_alta'=>$this->char(10)->comment('Fecha exacta de salida de taller'),
           'base'=>$this->char(1), 
            'esequipo'=>$this->char(1)->comment(' Marcador para saber si es equipos o no'),  
            'interno'=>$this->char(1)->comment(' Si pertenece a la empresa o a un cliente'), ///
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