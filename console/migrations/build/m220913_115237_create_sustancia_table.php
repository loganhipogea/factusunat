<?php
use console\migrations\baseMigration;
class m220913_115237_create_sustancia_table extends baseMigration
{
   public $table='{{%sustancia}}';    
    public function safeUp()
    {
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'descripcion'=>$this->string(40),
            'densidad'=>$this->decimal(12,5),
            'dureza'=>$this->decimal(12,5),
        ]);
      }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
