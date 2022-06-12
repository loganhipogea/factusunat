<?php
use console\migrations\baseMigration;
class m220612_033539_create_conversiones_table extends baseMigration
{
    const NAME_TABLE='{{%conversiones}}';
 const NAME_TABLE_MAESTRO='{{%maestrocompo}}';
const NAME_TABLE_UM='{{%ums}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
             //'codum1' => $this->string(4)->notNull()->append($this->collateColumn()),
             'codum' => $this->string(4)->notNull()->append($this->collateColumn()),
             'valor1'=>$this->double()->notNull(),
             //'valor2'=>$this->double()->notNull(),
        'codart' => $this->string(14)->notNull()->append($this->collateColumn()),
             
                        ],$this->collateTable());
            $this->paramsFk=[
                $table,
                'codum',
                 static::NAME_TABLE_UM,
                'codum'
            ];
         $this->addFk();  
         $this->paramsFk=[
                $table,
                'codart',
                 static::NAME_TABLE_MAESTRO,
                'codart'
            ];
         
          $this->addForeignKey($this->generateNameFk($table), $table,
              'codart', static::NAME_TABLE_MAESTRO,'codart');
               }
}

public function safeDown()
    {    $table=static::NAME_TABLE;
       if($this->existsTable($table)) {
            $this->dropTable($table);
        }
    }

}
