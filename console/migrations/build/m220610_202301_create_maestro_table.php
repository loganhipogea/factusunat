<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%maestro}}`.
 */
class m220610_202301_create_maestro_table extends baseMigration
{
  public $table='{{%maestrocompo}}';
   const NAME_TABLE_UM='{{%ums}}';
   public $paramsFk=[       
            '{{%maestrocompo}}',
            'codum',
            self::NAME_TABLE_UM,
            'codum'
               
         ];
    public function safeUp()
    {
        
       // $this->table=static::NAME_TABLE;
if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id'=>$this->primaryKey(),
            'codart'=>$this->string(14)->unique()->notNull()->append($this->collateColumn()),
            //'codigo'=>$this->string(10)->append($this->collateColumn()),
            'descripcion'=>$this->string(60)->notNull()->append($this->collateColumn()),
            'marca'=>$this->string(30)->append($this->collateColumn()),
            'modelo'=>$this->string(30)->append($this->collateColumn()),
            'numeroparte'=>$this->string(30)->append($this->collateColumn()),
              'codum'=>$this->string(4)->append($this->collateColumn()),
             'peso'=>$this->string(4)->append($this->collateColumn()),
             'codtipo'=>$this->char(3)->append($this->collateColumn()),
            'esrotativo'=>$this->char(1)->append($this->collateColumn()),
             'codean'=>$this->string(14)->append($this->collateColumn()),
             'codosce'=>$this->string(18)->append($this->collateColumn()),
              'cod1'=>$this->string(10)->append($this->collateColumn()),
             'cod2'=>$this->string(10)->append($this->collateColumn()),
             'codunsc'=>$this->string(16)->append($this->collateColumn()),
             'resolucion'=>$this->string(16)->append($this->collateColumn()),
            'regsan'=>$this->string(16)->append($this->collateColumn()),
            //'codigoitem'=>$this->string($this->specialSizeFor('codigoitem'))->append($this->collateColumn()), 
            //'escontenedor'=>$this->char(1)->append($this->collateColumn())
            ],
                $this->collateTable());
        $this->addFk();
        $this->putCombo($this->table, 'codtipo', 'MAQUINARIA');
        
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
