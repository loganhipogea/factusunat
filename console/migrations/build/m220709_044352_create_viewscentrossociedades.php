<?php
use console\migrations\baseMigration;
class m220709_044352_create_viewscentrossociedades extends baseMigration
{
    const NAME_VIEW_SOCIEDADES='{{%vw_sociedades}}';
    const NAME_VIEW_SUCURSALES='{{%vw_sucursales}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {         
         $vista=static::NAME_VIEW_SOCIEDADES; 
        if($this->existsTable($vista))
         $this->dropView($vista);
        
        $comando= $this->db->createCommand();       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.codpro', 'a.despro','a.rucpro','a.alias','a.codsoc'
        ])
    ->from(['a'=>'{{%clipro}}'])->where(['socio'=>'1']))->execute();
    
         $vista=static::NAME_VIEW_SUCURSALES; 
        if($this->existsTable($vista))
         $this->dropView($vista);
        
        $comando= $this->db->createCommand();       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.codcen', 'a.nomcen','b.codpro','b.codsoc'
        ])
    ->from(['a'=>'{{%centros}}'])->
     innerJoin('{{%clipro}} b', 'a.codpro=b.codpro')            
    ->where(['b.socio'=>'1']))->execute();
        
        }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $vista=static::NAME_VIEW_SOCIEDADES; 
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $vista=static::NAME_VIEW_SUCURSALES; 
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }

   
}
