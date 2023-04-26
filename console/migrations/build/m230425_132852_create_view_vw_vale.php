<?php

//use yii\db\Migration;
use console\migrations\baseMigration;
/**
 * Class m230425_132852_create_view_vw_vale
 */
class m230425_132852_create_view_vw_vale extends baseMigration
{
     const NAME_VIEW='{{%mat_vw_vale}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           $vista=static::NAME_VIEW;
        $comando= $this->db->createCommand(); 
        if($this->existsTable($vista)) {
         
            $this->dropView($vista);
        }
        
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select(['a.id',
      'a.numero', 'a.fecha','a.codmov','a.codpro','codal',
      'b.cant','b.um','b.codart','b.item','b.um','a.numerodoc','a.fechacon',
      'c.descripcion',
      'd.despro',
      'e.descripcion as transa'
         ])
    ->from(['a'=>'{{%mat_vale}}'])->
     innerJoin('{{%mat_detvale}} b', 'a.id=b.vale_id')->
     innerJoin('{{%maestrocompo}} c', 'c.codart=b.codart')->
     innerJoin('{{%transacciones}} e', 'a.codmov=e.codtrans')->
      innerJoin('{{%clipro}} d', 'd.codpro=a.codpro')           
                )->execute();
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
        
         
       
       /* $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.numero', 'a.fecha','a.codmov','a.codpro',
      'b.cant','b.um','b.codart','b.item','b.um',
      'c.descripcion',
         ])
    ->from(['a'=>'{{%mat_vale}}'])->
     innerJoin('{{%mat_detvale}} b', 'a.id=b.vale_id')->
     innerJoin('{{%maestrocompo}} c', 'c.codart=b.codart')
                )->execute();*/
    }
    
    }

    
}
