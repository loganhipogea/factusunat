<?php



/**
 * Class m240118_221007_alter_table_mat_guia
 */
class m240118_221007_alter_table_mat_guia extends \console\migrations\baseMigration
{ 
    
    public $table='{{%mat_guia}}';
    private $_fields=[];
    
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
         'codocuref'=>$this->char(3),
           'numdocref'=>$this->string(20),  
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
