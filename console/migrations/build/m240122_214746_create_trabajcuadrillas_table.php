<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%trabajcuadrillas}}`.
 */
class m240122_214746_create_trabajcuadrillas_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%trabajcuadrilla}}', [
            'id' => $this->primaryKey(),
            'cuadrilla_id'=>$this->integer(11),
            'codcuadrilla_id'=>$this->string(14)->append($this->collateColumn()),
           'trabajador_id'=>$this->integer(11),
             'codtra_id'=>$this->string(6)->append($this->collateColumn()),
             'turno_id'=>$this->integer(11),
            'textodetalle'=>$this->text()->append($this->collateColumn()),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%trabajcuadrilla}}');
    }
}
