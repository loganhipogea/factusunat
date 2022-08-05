<?php
use console\migrations\baseMigration;
class m220731_140625_alter_oplibrofk_table extends baseMigration
{
    const TABLE='{{%op_libro}}';
    const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->paramsFk=[
            self::TABLE,
            'detos_id',
           static::TABLE_PROCESOS,
            'id'
                    ];
        $this->dropFk();
         $this->paramsFk=[
            self::TABLE,
            'proc_id',
           static::TABLE_PROCESOS,
            'id'
                    ];
       $this->addFk();
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->paramsFk=[
            self::TABLE,
            'proc_id',
           static::TABLE_PROCESOS,
            'id'
                    ];
          $this->dropFk();
           $this->paramsFk=[
            self::TABLE,
            'detos_id',
           static::TABLE_PROCESOS,
            'id'
                    ];
         $this->addFk();
         
        
        
    }
}