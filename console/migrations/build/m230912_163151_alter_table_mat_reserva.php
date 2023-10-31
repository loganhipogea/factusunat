<?php

use console\migrations\baseMigration;

/**
 * Class m230912_163151_alter_table_mat_reserva
 */
class m230912_163151_alter_table_mat_reserva extends baseMigration
{
    public $table='{{%mat_detreq}}';
    public $campo='detreq_id';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->integer(11)); 
        }
        
         $this->campo='detres_id';
         if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo,$this->integer(11)); 
        }
        
        $this->putCombo('{{%mat_req}}','codest',
                [
                    '100'=>yii::t('base.names','CREADA'),
                    '101'=>yii::t('base.names','APROBADA'),
                    '999'=>yii::t('base.names','ANULADA'),
                    ]);
       $this->putCombo($this->table,'codest',
                [
                    '10'=>yii::t('base.names','CREADA'),
                    '20'=>yii::t('base.names','APROBADA'),
                    '99'=>yii::t('base.names','ANULADA'),
                      '30'=>yii::t('base.names','ATPARCIAL'),
                    '40'=>yii::t('base.names','ATENDIDA'),
                   '50'=>yii::t('base.names','RESERVADO'),       
                    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
          if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       $this->campo='detres_id';
        if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       $this->deleteCombo('{{%mat_req}}','codest');
        $this->deleteCombo($this->table,'codest');
    }

    
    
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230717_035208_alter_table_documentos cannot be reverted.\n";

        return false;
    }
    */
}
