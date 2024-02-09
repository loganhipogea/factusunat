<?php

use console\migrations\baseMigration;

/**
 * Class m240208_195440_create_putcompo_tiposOs
 */
class m240208_195440_create_putcompo_tiposOs extends baseMigration
{
  public $table='{{%op_os}}'; 
    public function safeUp()
    {
        $this->putCombo($this->table, 'tipoes', [
                                        'A'=>yii::t('base.names','EQUIPO ESTRUCTURAL'),
                                        'B'=>yii::t('base.names','COMPONENTE ROTATIVO'),
                                        'C'=>yii::t('base.names','VARIOS COMPONENTES ROTATIVOS'),
                                        'D'=>yii::t('base.names','GENERAL NO CATALOGADO'),
                ]);
    }

    
    public function safeDown()
    {
        $this->deleteCombo($this->table, 'tipoes');
    }
}