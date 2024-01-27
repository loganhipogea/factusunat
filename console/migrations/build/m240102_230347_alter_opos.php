<?php

use console\migrations\baseMigration;

/**
 * Class m240102_230347_alter_opos
 */
class m240102_230347_alter_opos extends baseMigration
{ 
    public $table='{{%op_os}}';
     private $_fields=[];
    
    
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
         'codcencli'=>$this->string(5),
         'serie'=>$this->string(40),
           // 'codsoc'=>$this->char(1),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
       
        foreach($this->buildSchemaFields() as $campo=>$columna){
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
       foreach($this->buildSchemaFields() as $campo=>$columna){
           if($this->existsColumn($this->table,$campo)){  
            $this->dropColumn($this->table,$campo); 
             } 
        } 
       
          
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231211_224852_alter_table_activos cannot be reverted.\n";

        return false;
    }
    */
}
