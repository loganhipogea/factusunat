<?php

use console\migrations\baseMigration;

/**
 * Class m231228_221413_alter_view_ingresos
 */
class m231228_221413_alter_view_ingresos extends baseMigration
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
      'b.item','b.cant','b.codum','b.codart','b.descripcion as descri','b.id as iddetalle',
      'b.codaf','b.serie','estadomaterial','rotativo','activo',
      'x.nomcen',
      'z.nomcen as nomcencli',       
         ])
    ->from(['a'=>'{{%mat_guia}}'])->
     innerJoin('{{%mat_detguia}} b', 'b.guia_id=a.id')->
     innerJoin('{{%centros}} x', 'x.codcen=a.codcen')-> 
     innerJoin('{{%centros}} z', 'z.codcen=a.codcencli')
      
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
