<?php
use console\migrations\baseMigration;
class m220817_154146CreateTableTelegramHooks extends baseMigration
{
    
    const NAME_TABLE='{{%tlbot_hooks}}';
   // const NAME_TABLE_APPS='{{%facultades}}';
     //const NAME_TABLE_PROVIDERS='{{%media_apps}}';
    public function safeUp()
    {
        
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
        'id'=>$this->primaryKey(),
        //'model'=>$this->string(150)->notNull()->append($this->collateColumn()),
        'comando'=>$this->integer(11)->notNull(),
         'chat_id'=>$this->integer(11)->notNull(),
        'time'=>$this->double(),
        'paso'=>$this->integer(3),
        'esfinal'=>$this->char(1),        
      ],$this->collateTable());
        
           }
                /* $this->addForeignKey($this->generateNameFk($table), $table,
              'codfac', static::NAME_TABLE_FACULTADES,'codfac');*/
               /* $this->addForeignKey($this->generateNameFk($table), $table,
              'app_id', static::NAME_TABLE_APPS,'id');  */
    }

    public function safeDown()
    {
        $table=static::NAME_TABLE; 
       if ($this->existsTable($table)){
            $this->dropTable($table);
        }

    }
}