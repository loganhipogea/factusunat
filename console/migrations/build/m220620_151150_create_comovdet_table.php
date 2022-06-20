<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%comovdet}}`.
 */
class m220620_151150_create_comovdet_table extends baseMigration
{ 
    public $table='{{%com_ovdet}}'; 
    const TABLE_NAME_CENTROS='{{%centros}}';
    const TABLE_NAME_ALMACENES='{{%almacenes}}';
     const TABLE_NAME_OV='{{%com_ov}}';
    const TABLE_NAME_MATERIALES='{{%maestrocompo}}';
    
    //const TABLE_NAME_CENTROS='{{%centros}}';
    /*const TABLE_NAME_CENTROS='{{%centros}}';
    const TABLE_NAME_ALMACENES='{{%almacenes}}';*/
    public function safeUp()
    { 
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'ov_id' => $this->integer(11)->notNull(),
            'item'=>$this->char(3)->notNull()->append($this->collateColumn()),
            'codsoc' =>  $this->char(1)->append($this->collateColumn()),
            'codcen'=>$this->char(4)->notNull()->append($this->collateColumn()),
             'codcen'=>$this->char(4)->notNull()->append($this->collateColumn()),
            'codal'=>$this->char(4)->notNull()->append($this->collateColumn()),
            'codum'=>$this->string(4)->notNull()->append($this->collateColumn()),
            'codart'=>$this->string(14)->notNull()->append($this->collateColumn()),
            'punit'=>$this->decimal(8,2)->notNull(),
            'pventa'=>$this->decimal(8,2)->notNull(),            
            ],
           $this->collateTable());
        $this->paramsFk=[
            $this->table,
            'codcen',
            self::TABLE_NAME_CENTROS,
            'codcen'
                ];        
         $this->addFk();
         
         $this->paramsFk=[
            $this->table,
            'codal',
            self::TABLE_NAME_ALMACENES,
            'codal'
                ];        
         $this->addFk();

             $this->paramsFk=[
            $this->table,
            'ov_id',
            self::TABLE_NAME_OV,
            'id'
                ];        
         $this->addFk();
         
          $this->paramsFk=[
            $this->table,
            'codart',
            self::TABLE_NAME_MATERIALES,
            'codart'
                ];        
         $this->addFk();         
        
        }
        
      }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
