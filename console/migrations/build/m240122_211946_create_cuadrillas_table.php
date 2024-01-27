<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%cuadrillas}}`.
 */
class m240122_211946_create_cuadrillas_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cuadrillas}}', [
            'id' => $this->primaryKey(),
            'codigo'=>$this->string(14)->append($this->collateColumn()),
            'codarea_id'=>$this->char(3)->append($this->collateColumn()),
             'codgrupo_id'=>$this->char(14)->append($this->collateColumn()),          
            'descripcion'=>$this->string(80)->append($this->collateColumn()),
            'textodetalle'=>$this->text()->append($this->collateColumn()),
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cuadrillas}}');
    }
}
