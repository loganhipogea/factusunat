<?php
/**
 * Class m231228_225712_alter_detgui
 */
class m231228_225712_alter_detgui extends \console\migrations\baseMigration
{
    public $table='{{%mat_detguia}}';
    private $_fields=[];
    
     
     private function getFieldsTomodify(){
        return (count($this->_fields)>0)?$this->_fields:$this->buildSchemaFields();
     }
     
    private function buildSchemaFields(){
        return [
           
         'codocu'=>$this->char(3),
           'codsoc'=>$this->char(1),  
            //'activo'=>$this->char(1),
              'codestado'=>$this->char(2),  
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
        $this->putCombo($this->table, 'codestado',[
            '10'=>'CREADO',
            '20'=>'APROBADO',
            '99'=>'ANULADO',
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
