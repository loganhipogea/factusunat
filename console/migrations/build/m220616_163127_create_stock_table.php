<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%stock}}`.
 */
class m220616_163127_create_stock_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%stock}}'; 
    const TABLE_NAME_MATERIALES='{{%maestrocompo}}';
    const TABLE_NAME_CENTROS='{{%centros}}';
    const TABLE_NAME_ALMACENES='{{%almacenes}}';
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
$this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codart'=>$this->string(14)->notNull()->append($this->collateColumn()),
            'codcen'=>$this->char(4)->notNull()->append($this->collateColumn()),
            'cant' =>$this->decimal(8,3),
            'um' =>  $this->string(4)->append($this->collateColumn()),
           'ubicacion' =>$this->string(20)->append($this->collateColumn()),
            'cantres' =>$this->decimal(8,3),
             'codal' =>  $this->char(4)->append($this->collateColumn()),
            'valor' =>$this->decimal(12,3),
           'lastmov'=> $this->string(10)->append($this->collateColumn()),
         
            ],
           $this->collateTable());
        $this->paramsFk=[
            $this->table,
            'codart',
            self::TABLE_NAME_MATERIALES,
            'codart'
                ];
         $this->addFk();
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
       /*$this->addForeignKey($this->generateNameFk($table),
                    $table,'pago_id', static::TABLE_PORPAGAR,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'tipomov', static::TABLE_TIPOMOV,'codigo');*/
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
