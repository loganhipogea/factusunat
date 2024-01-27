<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%table_estructuramaterail}}`.
 */
class m231229_202013_create_table_estructuramaterail_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mat_estructuracompo}}', [
            'id' => $this->primaryKey(),
            'maestro_id'=>$this->integer(11),
            'codart'=>$this->string(14)->append($this->collateColumn()),
            'descri'=>$this->string(50)->append($this->collateColumn()),
            'item'=>$this->string(3)->append($this->collateColumn()),
            'parent_id'=>$this->integer(11),
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mat_estructuracompo}}');
    }
}
