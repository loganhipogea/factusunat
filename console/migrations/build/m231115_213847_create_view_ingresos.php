<?php

use console\migrations\baseMigration;
use yii\db\Expression;
class m231115_213847_create_view_ingresos extends baseMigration
{
     const NAME_VIEW='{{%mat_vw_ingresos}}';
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
    ->select(['a.*',
      'b.item','b.cant','b.codum','b.codart','b.descripcion as descri',
      'b.codaf','b.serie'
       
         ])
    ->from(['a'=>'{{%mat_guia}}'])->
     innerJoin('{{%mat_detguia}} b', 'b.guia_id=a.id')
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
    }
    
    }
}
