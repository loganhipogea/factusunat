<?php

use console\migrations\baseMigration;

/**
 * Class m231211_224852_alter_table_activos
 */
class m231211_224852_alter_table_activos extends baseMigration
{
     public $table='{{%mat_activos}}';
     private $_fields=[];
    
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
         'codart'=>$this->string(14),
        'tipo'=>$this->char(1),
            'codsoc'=>$this->char(1),
           'codocu'=>$this->char(3),
            'codestado'=>$this->char(2),
             'modalidad'=>$this->char(1),
            
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
        
       // $size=$this->getColumnSize($this->table,'descripcion');
        if($this->existsColumn($this->table,'descripcion')){  
            $this->alterColumn($this->table,'descripcion', $this->string(60));
             } 
       
         $this->putCombo($this->table, 'tipo', 
                 [
                     'A'=>'FRONTONERO',
                     'B'=>'UTILITARIO',
                     //'C'=>'ALQUILADO',
                    ]);
           $this->putCombo($this->table, 'codestado', 
                 [
                     '10'=>'OPERATIVO',
                     '20'=>'DE BAJA',
                     //'C'=>'ALQUILADO',
                    ]);
            $this->putCombo($this->table, 'modalidad', 
                 [
                     'V'=>'VENTA',
                     'Z'=>'ALQUILADO A CLIENTE',
                     'V'=>'PROPIO',
                     'Z'=>'ALQUILADO A PROVEEDOR',
                     //'C'=>'ALQUILADO',
                    ]);
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
        
         if($this->existsColumn($this->table,'descripcion')){  
            $this->alterColumn($this->table,'descripcion', $this->string(40));
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
