<?php

use console\migrations\baseMigration;
use yii\db\Expression;
/**
 * Class m220619_023235_create_view_stock
 */
class m220619_023235_create_view_stock extends baseMigration
{
    const NAME_VIEW='{{%logi_vw_stock}}';
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
      'a.id', 'a.codart','a.codcen','a.codal','a.um','a.cant',
        'a.ubicacion', 'a.valor','a.pventa', 
        'b.descripcion', 'b.marca','b.modelo',New Expression('a.valor*a.cant as valortotal')   
         ])
    ->from(['a'=>'{{%stock}}'])->
     innerJoin('{{%maestrocompo}} b', 'a.codart=b.codart')     
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
