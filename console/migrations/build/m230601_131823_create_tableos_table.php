<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%tableos}}`.
 */
class m230601_131823_create_tableos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%op_tableos}}';    
    public function safeUp() 
    { 
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
    }
}
