<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%prd_planos_revisiones}}`.
 */
class m240229_152039_create_prd_planos_revisiones_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prd_planos_revisiones}}', [
            'id' => $this->primaryKey(),
             'plano_id'=>$this->integer(11),
            'cambio'=>$this->string(100)->comment('descricion de la modificacion')->append($this->collateColumn()),
            'texto'=>$this->text()->comment('descricion de la modificacion')->append($this->collateColumn()),
            'fecha'=>$this->char(10)->append($this->collateColumn()),
            'rev'=>$this->char(3)->comment('CODIGO DE REVISION')->append($this->collateColumn()),
            'final'=>$this->char(1)->comment('Activo, solo puedehaber una revision activa por plano ')->append($this->collateColumn()),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prd_planos_revisiones}}');
    }
}
