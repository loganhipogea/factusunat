<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%clipro}}`.
 */
class m220610_072752_create_clipro_table extends baseMigration
{
    const NAME_TABLE='{{%clipro}}';
    //const NAME_TABlE_DIRECCIONES='{%direcciones}';
        public function safeUp()
    {
 
if ($this->db->schema->getTableSchema(static::NAME_TABLE, true) === null) {
        $this->createTable(static::NAME_TABLE, [
            'codpro' => $this->char(6)->notNull()->append($this->collateColumn()),
            'despro' => $this->string(60)->notNull()->append($this->collateColumn()), 
            'rucpro'=>$this->string(15)->notNull()->append($this->collateColumn()), 
            'telpro'=>$this->string(15)->append($this->collateColumn()),  
            'web'=>$this->string(85)->append($this->collateColumn()), 
            'deslarga'=>$this->text()->append($this->collateColumn()),
             ], $this->collateTable());
       $this->addPrimaryKey($this->generateNameFk(static::NAME_TABLE),static::NAME_TABLE, 'codpro');      
        }
   
        
        }
        
   

    
    
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        
        if ($this->db->schema->getTableSchema(static::NAME_TABLE, true) !== null) {
            $this->dropTable(static::NAME_TABLE);
        }
    }
}
