<?php

use console\migrations\baseMigration;

/**
 * Class m230519_121417_create_tables_web
 */
class m230519_121417_create_tables_web extends baseMigration
{
     public $table='{{%borrar_menu}}';  
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*Crear la tabla de Menus
         * 
         */
         if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'opcion'=> $this->text()->append($this->collateColumn()),            
              'parent_id'=>$this->integer(11) ,    
        ]);
      }
      
      
      

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230519_121417_create_tables_web cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230519_121417_create_tables_web cannot be reverted.\n";

        return false;
    }
    */
}
