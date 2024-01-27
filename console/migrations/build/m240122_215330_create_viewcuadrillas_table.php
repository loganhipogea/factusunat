<?php

use console\migrations\baseMigration;
use yii\db\Expression;
/**
 * Handles the creation of table `{{%viewcuadrillas}}`.
 */
class m240122_215330_create_viewcuadrillas_table extends baseMigration
{  
    
    
    const NAME_VIEW='{{%vw_cuadrillas}}';
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
       // $expresion=New 
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select(['a.*',
      'b.id as idcuadrilla','b.codigo as codcuadrilla','b.descripcion as descricuadrilla',
      'c.codigotra',new Expression("CONCAT(ap,'-',nombres) as nombres"),
      'd.codarea','d.desarea'
        ])
    ->from(['a'=>'{{%trabajcuadrilla}}'])->
     innerJoin('{{%cuadrillas}} b', 'b.id=a.cuadrilla_id')->
     innerJoin('{{%trabajadores}} c', 'c.id=a.trabajador_id')-> 
     innerJoin('{{%areas}} d', 'd.codarea=b.codarea_id')
      
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
