<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%mat_guia}}`.
 */
class m231115_010102_create_mat_detguia_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    
    public $table='{{%mat_detguia}}';
    
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
              'guia_id'=>$this->integer(11)->notNull(),
            'item'=>$this->char(3)->append($this->collateColumn()),
             'codum'=>$this->string(4)->append($this->collateColumn()),
            'cant'=>$this->decimal(8,2)->notNull(),
            'codart'=>$this->string(14)->append($this->collateColumn()),
            'codaf'=>$this->string(14)->append($this->collateColumn()),
            'serie'=>$this->string(20)->append($this->collateColumn()),
            'descripcion'=>$this->string(40)->append($this->collateColumn()),
            'detalle'=>$this->text()->append($this->collateColumn()),
           
            ],
           $this->collateTable()
		   );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
