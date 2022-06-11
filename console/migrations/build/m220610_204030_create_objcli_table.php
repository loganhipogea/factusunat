<?php
use console\migrations\baseMigration;
class m220610_204030_create_objcli_table extends baseMigration
{
   public $table='{{%objcli}}';
   public $paramsFk=[];
 const NAME_TABLE_CLIPRO='{{%clipro}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
        
       
if(!$this->existsTable($this->table)) {
    $this->createTable($this->table, [
               'id'=>$this->primaryKey(),
         'codpro' => $this->char(6)->notNull()->append($this->collateColumn()),
         'descripcion' => $this->string(26)->notNull()->append($this->collateColumn()),
           'codigo' => $this->char(3)->notNull()->append($this->collateColumn()), 
        ],$this->collateTable());
    $this->paramsFk=[
            $this->table,
            'codpro',
            self::NAME_TABLE_CLIPRO,
            'codpro'
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
