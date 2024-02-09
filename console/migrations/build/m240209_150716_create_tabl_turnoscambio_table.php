<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%tabl_turnoscambio}}`.
 */
class m240209_150716_create_tabl_turnoscambio_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        
        $this->createTable('{{%turnoscambio}}', [
            'id' => $this->primaryKey(),
            'turnosasignaciones_id'=>$this->integer(11),
             'descripcion'=>$this->string(40)->append($this->collateColumn()),
             'detalles'=>$this->text()->append($this->collateColumn()),
             'ingreso'=>$this->integer(1),
            'aprobado'=>$this->char(1),
              'codocuref'=>$this->char(3)->append($this->collateColumn()),
             'numdocuref'=>$this->string(20)->append($this->collateColumn()), 
             'codmotivo'=>$this->char(3)->append($this->collateColumn()),
            'fecha'=>$this->char(19)->append($this->collateColumn()),
            'fecha_ingreso_prog'=>$this->char(19)->append($this->collateColumn()),
        ]);
        
        $this->putCombo('{{%turnoscambio}}', 'codmotivo', [
            '100'=>yii::t('base.names','CAMBIO DE TURNO'),
            '200'=>yii::t('base.names','PERMISO'),
             '300'=>yii::t('base.names','INGRESO'),
            '400'=>yii::t('base.names','CESE'),
            '500'=>yii::t('base.names','VACACIONES'),
             '600'=>yii::t('base.names','LICENCIA'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsTable('{{%turnoscambio}}')){
          $this->deleteCombo('{{%turnoscambio}}', 'codmotivo');
          $this->dropTable('{{%turnoscambio}}');
        
        }
        
    }
}
