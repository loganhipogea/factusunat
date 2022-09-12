<?php
use console\migrations\baseMigration;
class m220817_154145CreateTableTelegramUsers extends baseMigration
{
    
    const NAME_TABLE='{{%tlbot_users}}';
   // const NAME_TABLE_APPS='{{%facultades}}';
     //const NAME_TABLE_PROVIDERS='{{%media_apps}}';
    public function safeUp()
    {
        
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
        'id'=>$this->primaryKey(),
        //'model'=>$this->string(150)->notNull()->append($this->collateColumn()),
        'user_id'=>$this->integer(11)->notNull(),
         'chat_id'=>$this->integer(11)->notNull(),
        'tallerdet_id'=>$this->integer(11),
        'codfac'=>$this->string(8)->notNull(),
        'activo'=>$this->char(1),
        'role'=>$this->char(1),
        'cuando'=>$this->char(19),
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