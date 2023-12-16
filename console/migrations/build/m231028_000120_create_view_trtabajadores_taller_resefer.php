<?php

use console\migrations\baseMigration;
use yii\db\Expression;
/**
 * Class m231028_000120_create_view_trtabajadores_taller_resefer
 */
class m231028_000120_create_view_trtabajadores_taller_resefer extends baseMigration
{
     const NAME_VIEW='{{%op_vw_trabataller}}';
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
    ->select(['b.*',
      'c.nombre as nombrearea',
      'a.codtra','a.area_id',
        new Expression("CONCAT(b.ap,'-',b.am,'-',b.nombres )as nombrecompleto")
         ])
    ->from(['a'=>'{{%resef_trabataller}}'])->
     innerJoin('{{%trabajadores}} b', 'b.codigotra=a.codtra')->
     innerJoin('{{%resef_areas}} c', 'a.area_id=c.id')
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
