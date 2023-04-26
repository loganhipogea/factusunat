<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%view_stock}}`.
 */
class m230425_171305_create_view_stock_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%mat_vw_stock}}';  
    
    
    public function safeUp()
    {   
        $comando= $this->db->createCommand(); 
        if($this->existsTable($this->table)) {         
            $this->dropView($this->table);
        }
        
        $comando->createView($this->table,
                (new \yii\db\Query())
    ->select(['a.*',      
      'b.descripcion'
         ])
    ->from(['a'=>'{{%mat_stock}}'])->
     innerJoin('{{%maestrocompo}} b', 'b.codart=a.codart')           
                )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsTable($this->table)) {
            $comando= $this->db->createCommand();
         $comando->dropView($this->table);
        }
    }
}
