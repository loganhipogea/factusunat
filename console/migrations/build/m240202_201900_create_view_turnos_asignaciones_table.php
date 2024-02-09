<?php

use console\migrations\baseMigration;
use yii\db\Expression;
/**
 * Handles the creation of table `{{%view_turnos_asignaciones}}`.
 */
class m240202_201900_create_view_turnos_asignaciones_table extends baseMigration
{
    
    const NAME_VIEW='{{%vw_turnos_asignaciones}}';
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
      'd.codarea','d.desarea',
      't.desturno',
        'g.fecha','d.desarea','g.activo as actiasignado','g.turno_id as idturno',
        ])
    ->from(['a'=>'{{%trabajcuadrilla}}'])->
     innerJoin('{{%cuadrillas}} b', 'b.id=a.cuadrilla_id')->    
     innerJoin('{{%trabajadores}} c', 'c.id=a.trabajador_id')-> 
     innerJoin('{{%areas}} d', 'd.codarea=b.codarea_id')->
      innerJoin('{{%turnosasignaciones}} g','g.trabajcuadrilla_id=a.id')->
     innerJoin('{{%turnos}} t', 't.id=g.turno_id')
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
