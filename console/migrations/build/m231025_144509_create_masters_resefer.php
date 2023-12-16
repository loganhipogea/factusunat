<?php

use console\migrations\baseMigration;

/**
 * Class m231025_144509_create_masters_resefer
 */
class m231025_144509_create_masters_resefer extends baseMigration
{
    const TABLE_FAMILIA='{{%familia}}';
    const TABLE_SUBFAMILIA='{{%subfamilia}}';
	const TABLE_SUBSUBFAMILIA='{{%subsubfamilia}}';
    const TABLE_MATERIALES='{{%maestrocompo}}';
  
    public function safeUp()
    {
 $table=static::TABLE_FAMILIA;
        //var_dump(static::NAME_TABlE);die();

   	 
			 if(!$this->existsTable($table)) {
       $this->createTable(
	         $table, [
			'id'=>$this->primaryKey(),
            'codfam'=>$this->char(2)->notNull(),
			'descrifam'=>$this->string(50)->append($this->collateColumn()),
            ],
           $this->collateTable()
		   );
           
        }	
	

	
	 $table=static::TABLE_SUBFAMILIA;		 
	 if(!$this->existsTable($table)) {
       $this->createTable(
	         $table, [
			 'id'=>$this->primaryKey(),
			 'familia_id'=>$this->integer(11),
            'codsubfam'=>$this->char(2)->notNull(),
			'codfam'=>$this->char(2)->append($this->collateColumn()),
			'descrisubfam'=>$this->string(50)->append($this->collateColumn()),
            ],
           $this->collateTable()
		   );
           		   
		 }	  


     $table=static::TABLE_SUBSUBFAMILIA;		 
	 if(!$this->existsTable($table)) {
       $this->createTable(
	         $table, [
			  'id'=>$this->primaryKey(),
			 'familiasub_id'=>$this->integer(11),
            'codsubsubfam'=>$this->char(2)->notNull(),
			'codsubfam'=>$this->char(2)->append($this->collateColumn()),
			'descrisubsubfam'=>$this->string(50)->append($this->collateColumn()),
            ],
           $this->collateTable()
		   );	

             
        }
		
	//ALARGANDO EL CAMPO DESCRIPCION DEL MAESTRO DE MATERIALES	
		 $table=static::TABLE_MATERIALES;
		 if($this->existsColumn($table,'descripcion')){  
            $this->alterColumn($table,'descripcion',$this->string(80)); 
        }
		
		if(!$this->existsColumn($table,'codfam')){  
            $this->addColumn($table,'codfam',$this->char(2)); 
        }
		
		if(!$this->existsColumn($table,'codsubfam')){  
            $this->addColumn($table,'codsubfam',$this->char(2)); 
        }
		
		if(!$this->existsColumn($table,'codsubsubfam')){  
            $this->addColumn($table,'codsubsubfam',$this->char(2)); 
        }
		
		if(!$this->existsColumn($table,'fasubsub_id')){  
            $this->addColumn($table,'fasubsub_id',$this->integer(11)); 
        }
		
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    { 
	    $table=static::TABLE_MATERIALES;
		if($this->existsColumn($table,'codsubsubfam')){  
            $this->dropColumn($table,'codsubsubfam'); 
        }
		if($this->existsColumn($table,'codsubfam')){  
            $this->dropColumn($table,'codsubfam'); 
        }
		if($this->existsColumn($table,'codfam')){  
            $this->dropColumn($table,'codfam'); 
        }
		
		if($this->existsColumn($table,'descripcion')){  
            $this->alterColumn($table,'descripcion',$this->string(60)); 
        }
		
	$table=static::TABLE_SUBSUBFAMILIA;		 
	 if($this->existsTable($table)) {
       $this->dropTable( $table);
        }	
	$table=static::TABLE_SUBFAMILIA;		 
	 if($this->existsTable($table)) {
       $this->dropTable( $table);
        }		
		
	$table=static::TABLE_FAMILIA;		 
	 if($this->existsTable($table)) {
       $this->dropTable( $table);
        }		
       
    }

    
}
