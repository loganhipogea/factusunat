<?php

use console\migrations\baseMigration;

/**
 * Class m221215_002707_create_view_petoferta
 */
class m221215_002707_create_view_petoferta extends baseMigration
{
  const NAME_VIEW='{{%mat_vw_petoferta}}';
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
     'a.id','a.numero','a.fecha','a.codmon','a.igv','a.codpro',
     'b.id as iddetalle','b.item','b.codart','b.tipo',
     'b.codum','b.cant','b.punit','b.igv as igvdet',
     'b.ptotal','b.pventa','b.descripcion',
     'c.despro',
      ])
    ->from(['a'=>'{{%mat_petoferta}}'])->
     innerJoin('{{%mat_detpetoferta}} b', 'b.petoferta_id=a.id')->
     innerJoin('{{%clipro}} c', 'c.codpro=a.codpro')
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

    
}
