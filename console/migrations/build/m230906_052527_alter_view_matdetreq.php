<?php

use console\migrations\baseMigration;

/**
 * Class m230906_052527_alter_view_matdetreq
 */
class m230906_052527_alter_view_matdetreq extends baseMigration
{
    
    const NAME_VIEW='{{%mat_vw_req}}';
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
     'a.id', 'a.codtra', 'a.numero','a.fechaprog','a.fechasol','a.descripcion',
      'b.ceco_id' ,'b.id as iddet','b.codest','b.codal','b.tipo','b.req_id','b.codart','b.descripcion as descridetalle','b.cant','b.um','b.imptacion','b.tipim','b.item','b.proc_id','b.os_id','b.detos_id','b.fechaprog as fprog',
      'c.ap', 'c.am','c.nombres',
       'd.despro'
         ])
    ->from(['a'=>'{{%mat_req}}'])->
     innerJoin('{{%mat_detreq}} b', 'b.req_id=a.id')->
     leftJoin('{{%trabajadores}} c', 'c.codigotra=a.codtra')->
     leftJoin('{{%clipro}} d', 'b.codpro=d.codpro')
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
