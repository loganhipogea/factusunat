<?php

use console\migrations\baseMigration;

/**
 * Class m240217_162614_alter_tabl_detpartetable
 */
class m240217_162614_alter_tabl_detpartetable extends baseMigration
{
    public $table='{{%op_tareodet}}';
    private $foraneas=[
        'fk_op_tareodet_detos_id_op_osdet_id',
        'fk_op_tareodet_os_id_op_os_id',
        'fk_op_tareodet_proc_id_op_procesos_id',
        'fk_op_tareodet_tareo_id_op_tareo_id',
        'fk_op_tareodet_tarifa_id_op_tarifa_hombre_id',
        'fk_op_tareo_direcc_id_direcciones_id'
        ];
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      foreach($this->foraneas as $columna=>$llave){
            if ($this->existsFk($this->table, $llave)){
                  $this->dropForeignKey($llave, $this->table);
               }

      }
        if ($this->existsFk('{{%op_tareo}}', 'fk_op_tareo_direcc_id_direcciones_id')){
                  $this->dropForeignKey($llave, '{{%op_tareo}}');
               } 
      
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         
      
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240217_162614_alter_tabl_detpartetable cannot be reverted.\n";

        return false;
    }
    */
}
