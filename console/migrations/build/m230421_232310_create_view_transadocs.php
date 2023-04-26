<?php

use yii\db\Migration;

/**
 * Class m230421_232310_create_view_transadocs
 */
class m230421_232310_create_view_transadocs extends console\migrations\baseMigration
{ const NAME_VIEW='{{%mat_vw_transadocs}}';
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
      'a.*', 
        'b.id', 'b.tipodoc','b.codestado',
        'c.codocu','c.desdocu','c.modelo'
         ])
    ->from(['a'=>'{{%transacciones}}'])->
     innerJoin('{{%transadocs}} b', 'a.codtrans=b.codtrans')->
      innerJoin('{{%documentos}} c', 'b.codocu=c.codocu')
     
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
