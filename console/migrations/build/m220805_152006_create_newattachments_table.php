<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%newattachments}}`.
 */
class m220805_152006_create_newattachments_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%newattachments}}';    
    public function safeUp()
    {
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name'=>$this->string(255)->notNull()->append($this->collateColumn()),
             'model'=>$this->string(255)->notNull()->append($this->collateColumn()),
             'itemId'=>$this->integer(11)->notNull(),
            'hash'=>$this->string(255)->notNull()->append($this->collateColumn()),
            'size'=>$this->integer(11)->notNull(),
            'type'=>$this->string(255)->notNull()->append($this->collateColumn()),
            'mime'=>$this->string(255)->notNull()->append($this->collateColumn()),
            'detalle'=>$this->text()->append($this->collateColumn()),
            'titulo'=>$this->string(50)->append($this->collateColumn()),
            'cuando'=>$this->string(19)->append($this->collateColumn()),
             'codocu'=>$this->char(3)->append($this->collateColumn()),
            'user_id'=>$this->integer(11)->notNull(),
        ],
           $this->collateTable());
      }else{
          $this->addColumn($this->table, 'detalle', $this->text());
          $this->addColumn($this->table, 'titulo', $this->string(50));
           $this->addColumn($this->table, 'cuando', $this->string(19));
            $this->addColumn($this->table, 'codocu', $this->char(3));
             $this->addColumn($this->table, 'user_id', $this->integer(11));
       }
    } 

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }else{
           $this->dropColumn($table, 'detalle');
          $this->dropColumn($table, 'titulo');
           $this->dropColumn($table, 'cuando');
            $this->dropColumn($table, 'codocu');
             $this->dropColumn($table, 'user_id'); 
        }
    }
}
