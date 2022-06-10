<?php

use console\migrations\baseMigration;

/**
 * Handles adding columns to table `{{%menu}}`.
 */
class m220609_205548_add_icon_column_to_menu_table extends baseMigration
{
     public $table='{{%menu}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
   if(!$this->existsColumn($this->table,'icon')){  
        $this->addColumn('{{%menu}}', 'icon', $this->string(40));
     }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       if($this->existsColumn($this->table,'icon')){  
        $this->dropColumn('{{%menu}}', 'icon');
         }
                }
}
