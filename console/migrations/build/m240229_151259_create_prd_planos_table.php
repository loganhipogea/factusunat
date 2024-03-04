<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%prd_planos}}`.
 */
class m240229_151259_create_prd_planos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prd_planos}}', [
            'id' => $this->primaryKey(),
            'codart'=>$this->string(14)->comment('No necesarimente es obligatorio')->append($this->collateColumn()),
            'descriplano'=>$this->string(60)->comment('descricion del plano')->append($this->collateColumn()),
            'comentario'=>$this->text()->append($this->collateColumn()),
            'activo_id'=>$this->integer(11),
            'rol'=>$this->string(80)->comment('Rol de acceso a este plano')->append($this->collateColumn()),
            'fecha'=>$this->char(10)->comment('Fecha de creacion del plano')->append($this->collateColumn()),
             'revision'=>$this->char(3)->comment('numero de revision actual 001 002 003')->append($this->collateColumn()),
             'matdespiece_id'=>$this->integer(11),
             'codigo'=>$this->string(30)->comment('CODIGO RESFER DEL PLANO')->append($this->collateColumn()),
             'current_status'=>$this->string(4)->comment('CODIGO del STATUS')->append($this->collateColumn()),
            'status'=>$this->string(40)->comment('status  cre\ap\anu')->append($this->collateColumn()),
            
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prd_planos}}');
    }
}
