<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%centros}}`.
 */
class m220610_085504_create_centros_table extends baseMigration
{
   
    const NAME_TABLE='{{%centros}}';
    const NAME_TABLE_CLIPRO='{{%clipro}}';
     public $paramsFk=[
            self::NAME_TABLE,
            'codpro',
            self::NAME_TABLE_CLIPRO,
            'codpro'
                ];
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
 
if (!$this->existsTable(static::NAME_TABLE, true)) {
        $this->createTable(static::NAME_TABLE, [
            'codcen' => $this->string(5)->append($this->collateColumn()),
            'nomcen' => $this->string(60)->notNull()->append($this->collateColumn()), 
            'codpro'=>$this->string(6)->notNull()->append($this->collateColumn()), 
            'descricen'=>$this->text()->append($this->collateColumn()),
             ], $this->collateTable());
       $this->addPrimaryKey('pk_centros45',static::NAME_TABLE, 'codcen');
        $this->addFk();
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190106_063220_create_table_centros cannot be reverted.\n";

        return false;
    }
    */
}
