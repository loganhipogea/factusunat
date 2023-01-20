<?php
use console\migrations\baseMigration;

/**
 * Class m230118_223733_create_view_activocecos
 */
class m230118_223733_create_view_activocecos extends baseMigration
{
    const NAME_VIEW='{{%mat_vw_activoceco}}';
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
     'a.codmon','a.valor',
     'b.id as idactivo','b.codigo as codactivo', 'b.descripcion','b.marca','b.modelo','b.serie','b.v_adquisicion','b.vida_util','b.v_rescate',
     'c.id as idceco', 'c.codigo as codceco','c.descripcion as descriceco',
      ])
    ->from(['a'=>'{{%mat_activoscecos}}'])->
     innerJoin('{{%mat_activos}} b', 'a.activo_id=b.id')->
     innerJoin('{{%cc_cc}} c', 'c.id=a.ceco_id')
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
