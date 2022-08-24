<?php
namespace console\migrations\build;

use console\migrations\baseMigration;
class m220817_154148CreateTableTlbotQueque  extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const NAME_TABLE='{{%tlbot_queque}}';
    public function safeUp()
    {
        $this->createTable(self::NAME_TABLE, [
            'id'=>$this->primaryKey(),
            
            'cuando' => $this->char(19),
             'tipo' => $this->char(3),
            
        ], $this->collateTable());
        //$this->addPrimaryKey('tlgrm_messages_PK', 'tlgrm_messages', 'time');

        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    { $table=static::NAME_TABLE; 
       if ($this->existsTable($table)){
            $this->dropTable($table);
        }

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M210913015026CreateTableTelegramMensajes cannot be reverted.\n";

        return false;
    }
    */
}
