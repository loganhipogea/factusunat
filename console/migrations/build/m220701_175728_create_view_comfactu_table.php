<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%view_comfactu}}`.
 */
class m220701_175728_create_view_comfactu_table extends baseMigration
{
   const NAME_VIEW='{{%com_vw_factudet}}';
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
      'a.id', 'a.codsoc','a.numero','a.femision','a.fvencimiento',
        'b.codum','b.cant','b.descripcion','b.item','b.codart',
        'a.sunat_tipodoc', 'a.codmon','a.tipopago', 
        'a.rucpro', 'a.codcen','a.serie',
        'a.codestado', 'a.nombre_cliente','a.total'])
    ->from(['a'=>'{{%com_factura}}'])->
     innerJoin('{{%com_factudet}} b', 'a.id=b.factu_id')     
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
