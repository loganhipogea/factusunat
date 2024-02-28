<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%modelosbase}}`.
 */
class m240216_190933_create_modelosbase_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%modelosbase}}', [
            'id' => $this->primaryKey(),
            'descripcion'=>$this->string(40)->append($this->collateColumn()),
            'fecha'=>$this->string(10)->append($this->collateColumn()),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%modelosbase}}');
    }
}
