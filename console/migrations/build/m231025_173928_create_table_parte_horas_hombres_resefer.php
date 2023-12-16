<?php

use console\migrations\baseMigration;

/**
 * Class m231025_173928_create_table_parte_horas_hombres_resefer
 */
class m231025_173928_create_table_parte_horas_hombres_resefer extends baseMigration
{
    /**
     * {@inheritdoc}
     */
	 
	 public $table='{{%resef_parte}}';
    public function safeUp()
    {
	
	
	 if(!$this->existsTable($this->table)) {
       $this->createTable(
	         $this->table, [
			'id'=>$this->primaryKey(),
			'codtra'=>$this->string(6)->append($this->collateColumn()),
            'fecha'=>$this->char(10)->append($this->collateColumn()),
			'detalle'=>$this->text()->append($this->collateColumn()),
            ],
           $this->collateTable()
		   );
           
        }	
	 $this->table='{{%resef_partedet}}';
	
	 if(!$this->existsTable($this->table)) {
       $this->createTable(
	         $this->table, [
			'id'=>$this->primaryKey(),
			'parte_id'=>$this->integer(11),
			'orden_id'=>$this->integer(11),
			'area_id'=>$this->integer(11),
			'hinicio'=>$this->char(5)->append($this->collateColumn()),
            'hfin'=>$this->char(5)->append($this->collateColumn()),
			'actividad'=>$this->string(60)->append($this->collateColumn()),
			
            ],
           $this->collateTable()
		   );
           
        }	 
	$this->table='{{%resef_partedetplan}}';
	
	 if(!$this->existsTable($this->table)) {
       $this->createTable(
	         $this->table, [
			'id'=>$this->primaryKey(),
			'parte_id'=>$this->integer(11),
			'orden_id'=>$this->integer(11),
			'area_id'=>$this->integer(11),
			'hinicio'=>$this->char(5)->append($this->collateColumn()),
            'hfin'=>$this->char(5)->append($this->collateColumn()),
			'actividad'=>$this->string(60)->append($this->collateColumn()),
			
            ],
           $this->collateTable()
		   );
           
        }	 	
		

$this->table='{{%resef_areas}}';
	
	 if(!$this->existsTable($this->table)) {
       $this->createTable(
	         $this->table, [
			'id'=>$this->primaryKey(),
			
			'nombre'=>$this->string(60)->append($this->collateColumn()),
			
            ],
           $this->collateTable()
		   );
           
        }


$this->table='{{%resef_trabataller}}';
	
	 if(!$this->existsTable($this->table)) {
       $this->createTable(
	         $this->table, [
			'id'=>$this->primaryKey(),
			
			'codtra'=>$this->string(6)->append($this->collateColumn()),
			'area_id'=>$this->integer(11),
                     
            ],
           $this->collateTable()
		   );
           
        }

        
        
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	
         
       $this->table='{{%resef_trabataller}}';
	   
		if($this->existsTable($this->table)){  
            $this->dropTable($this->table); 
        }
        
        
        
        $this->table='{{%resef_partedetplan}}';
	   
		if($this->existsTable($this->table)){  
            $this->dropTable($this->table); 
        }
		 $this->table='{{%resef_partedet}}';
		if($this->existsTable($this->table)){  
            $this->dropTable($this->table); 
        }
		$this->table='{{%resef_parte}}';
		if($this->existsTable($this->table)){  
            $this->dropTable($this->table); 
        }
		
    }

   
}
