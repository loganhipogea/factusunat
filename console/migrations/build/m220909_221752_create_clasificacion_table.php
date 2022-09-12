<?php
use console\migrations\baseMigration;
class m220909_221752_create_clasificacion_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%clases}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codigo' => $this->string(30)->notNull()->append($this->collateColumn()),
            'descripcion' => $this->string(40)->notNull()->append($this->collateColumn()),
            
        ],$this->collateTable());
      }      
    $this->table='{{%caracteristicas}}';  
     if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'clase_id' => $this->integer(11),
            'codigo' => $this->string(30)->notNull()->append($this->collateColumn()),
            'descripcion' => $this->string(40)->notNull()->append($this->collateColumn()),
            
        ],$this->collateTable());
      }   
        $this->paramsFk=[
            $this->table,
            'clase_id',
            '{{%clases}}',
            'id'
                    ];
            $this->addFk();
            
     $this->table='{{%clases_caracteristicas}}';  
     if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'clase_id' => $this->integer(11),
            'caracteristica_id' => $this->integer(11),
            'codigo' => $this->string(30)->notNull()->append($this->collateColumn()),
            'descripcion' => $this->string(40)->notNull()->append($this->collateColumn()),
            
        ],$this->collateTable());
      }   
      
      $this->paramsFk=[
            $this->table,
            'clase_id',
            '{{%clases}}',
            'id'
                    ];
            $this->addFk(); 
            
        $this->paramsFk=[
            $this->table,
            'caracteristica_id',
            '{{%caracteristicas}}',
            'id'
                    ];
            $this->addFk(); 
            
            
       $this->table='{{%clasificacion}}';  
     if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'clasecarac_id' => $this->integer(11),
            //'modelo' => $this->integer(11),
            'modelo' => $this->string(100)->notNull()->append($this->collateColumn()),
            'valor'=>$this->decimal(14,4),
            'um'=>$this->string(10)->notNull()->append($this->collateColumn()),
            
        ],$this->collateTable());
      }   
      
      $this->paramsFk=[
            $this->table,
            'clasecarac_id',
            '{{%clases_caracteristicas}}',
            'id'
                    ];
            $this->addFk();       
            
      
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->table='{{%clasificacion}}'; 
        
         if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
        
         $this->table='{{%clases_caracteristicas}}'; 
         
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
        
        
         $this->table='{{%caracteristicas}}'; 
         
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
        
       $this->table='{{%clases}}'; 
         
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
        
       
        
    }
}
