<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%oplibro}}`.
 */
class m220721_120903_create_VWoplibro_table extends baseMigration
{
    const NAME_VIEW='{{%op_vw_libro}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {         
        
       
        
         $vista=static::NAME_VIEW; 
        if($this->existsTable($vista))
         $this->dropView($vista);
        
                $comando= $this->db->createCommand();       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
     'a.id', 'a.fecha', 'a.descripcion','a.direcc_id',
     'b.os_id', 'b.proc_id','b.detos_id','b.descripcion as descridetalle','b.detalle','b.tipo',
   
         ])
    ->from(['a'=>'{{%op_tareo}}'])->
     innerJoin('{{%op_libro}} b', 'b.tareo_id=a.id')
    
                )->execute();
    
}
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210409_183521_create_vw_porpagar cannot be reverted.\n";

        return false;
    }
    */
}
