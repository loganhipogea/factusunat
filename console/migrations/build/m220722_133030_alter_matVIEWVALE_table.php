<?php

use console\migrations\baseMigration;

/**
 * Class m220722_133030_alter_matVIEWVALE_table
 */
class m220722_133030_alter_matVIEWVALE_table extends baseMigration
{
     const NAME_VIEW='{{%mat_vw_vale}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
         
        
        $comando= $this->db->createCommand(); 
       $this->dropView($vista);
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select(['a.id',
      'a.numero', 'a.fecha','a.codmov','a.codpro',
      'b.cant','b.um','b.codart','b.item','b.um',
      'c.descripcion',
         ])
    ->from(['a'=>'{{%mat_vale}}'])->
     innerJoin('{{%mat_detvale}} b', 'a.id=b.vale_id')->
     innerJoin('{{%maestrocompo}} c', 'c.codart=b.codart')
                )->execute();
    }
}
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
            $comando= $this->db->createCommand();
         $comando->dropView($vista);
        
         
       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.numero', 'a.fecha','a.codmov','a.codpro',
      'b.cant','b.um','b.codart','b.item','b.um',
      'c.descripcion',
         ])
    ->from(['a'=>'{{%mat_vale}}'])->
     innerJoin('{{%mat_detvale}} b', 'a.id=b.vale_id')->
     innerJoin('{{%maestrocompo}} c', 'c.codart=b.codart')
                )->execute();
    }
    
    }

    
}
