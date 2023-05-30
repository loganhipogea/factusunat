<?php
class m230427_053821_view_mat_kardex_table extends \console\migrations\baseMigration
{
   const NAME_VIEW='{{%mat_vw_kardex}}';
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
      'b.descripcion', 
       'c.descripcion as descritransa', 
      'd.codocu','d.numerodoc','d.id as vale_id',
      'e.codpro','e.despro','x.valor','x.punit',
      'f.desdocu',
      
         ])
    ->from(['a'=>'{{%mat_kardex}}'])->
     innerJoin('{{%maestrocompo}} b', 'a.codart=b.codart')->
     innerJoin('{{%transacciones}} c', 'a.codmov=c.codtrans')->     
     innerJoin('{{%mat_detvale}} x', 'x.id=a.detvale_id')->
     innerJoin('{{%mat_vale}} d', 'd.id=x.vale_id')->          
     innerJoin('{{%clipro}} e', 'd.codpro=e.codpro') ->
     innerJoin('{{%documentos}} f', 'f.codocu=d.codocu')
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
