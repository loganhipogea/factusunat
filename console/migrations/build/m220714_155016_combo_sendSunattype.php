<?php

use console\migrations\baseMigration;
use frontend\modules\sunat\models\SunatSends;

/**
 * Class m220714_155016_combo_sendSunattype
 */
class m220714_155016_combo_sendSunattype extends baseMigration
{
    public $table='{{%sunat_sends}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->existsColumn($this->table,'tipo')){  
            $this->addColumn($this->table, 'tipo', $this->char(2));
        }
        $this->putCombo($this->table,'tipo',[
            SunatSends::TYPE_SEND_INVOICE=>'ENV-FACTURA',
            SunatSends::TYPE_SEND_VOUCHER=>'ENV-BOLETA',
            SunatSends::TYPE_SEND_SUMMARY=>'ENV-RESUMEN DIARIO', 
            SunatSends::TYPE_SEND_CREDIT_NOTE=>'ENV-NOTA DE CREDITO',
            SunatSends::TYPE_SEND_DEBIT_NOTE=>'ENV-NOTA DE DEBITO',
            SunatSends::TYPE_SEND_VOID_INVOICE=>'ENV-BAJA-FACTURA',
            SunatSends::TYPE_SEND_VOID_VOUCHER=>'ENV-BAJA-BOLETA',
            ]);

    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsColumn($this->table,'tipo')){  
            $this->dropColumn($this->table, 'tipo');
        }
        $this->deleteCombo($this->table,'tipo');
    }   
}
