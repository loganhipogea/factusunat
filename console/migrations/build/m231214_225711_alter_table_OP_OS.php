<?php

use console\migrations\baseMigration;

/**
 * Class m231214_225711_alter_table_OP_OS
 */
class m231214_225711_alter_table_OP_OS extends baseMigration
{
     public $table='{{%op_os}}';
     private $_fields=[];
    
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
         'codart'=>$this->string(14),
        'detgui_id'=>$this->integer(11),
            'ot'=>$this->string(15),
          'orden'=>$this->string(15),
             'finprog'=>$this->char(10),
             'fin'=>$this->char(10),
             'codest'=>$this->char(2),
            'avance'=>$this->integer(2),
            'destino'=>$this->string(25),
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
        
        $this->putCombo($this->table, 'codest', [
            '10'=>'ABIERTO',
            '20'=>'SUSPENDIDO',
            '30'=>'TERMINADO',
        ]);
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
      $this->deleteCombo($this->table, 'codest') ; 
       
          
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
