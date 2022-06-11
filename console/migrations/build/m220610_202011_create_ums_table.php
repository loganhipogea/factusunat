<?php
use console\migrations\baseMigration;
class m220610_202011_create_ums_table extends baseMigration
{
   const NAME_TABLE='{{%ums}}';
    public function safeUp()
    {
if(!$this->existsTable(static::NAME_TABLE)) {
        $this->createTable(static::NAME_TABLE, [
            'codum'=>$this->string(4)->append($this->collateColumn()),            
             'desum'=>$this->string(14)->append($this->collateColumn()),
             'dimension'=>$this->char(1)->append($this->collateColumn()),
            'escala'=>$this->integer(20),
            //'codigoitem'=>$this->string($this->specialSizeFor('codigoitem'))->append($this->collateColumn()), 
            //'escontenedor'=>$this->char(1)->append($this->collateColumn())
            ],
                $this->collateTable());
        $this->addPrimaryKey($this->generateNameFk(static::NAME_TABLE),static::NAME_TABLE, 'codum');
    }
    
    }
    /**
     * {@inheritdoc}
     */
     public function safeDown()
    {
       if($this->existsTable(static::NAME_TABLE))  {
            
           
           $this->dropTable(static::NAME_TABLE);
        }

    }
}
