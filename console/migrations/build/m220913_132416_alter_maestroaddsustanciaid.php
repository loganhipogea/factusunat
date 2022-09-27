<?php

use yii\db\Migration;
use console\migrations\migrationMenu;
use console\migrations\baseMigration;
/**
 * Class m220913_132416_alter_maestroaddsustanciaid
 */
class m220913_132416_alter_maestroaddsustanciaid extends baseMigration
{
    public $table='{{%maestrocompo}}';
    public $campo='sustancia_id';
   /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if(!$this->existsColumn($this->table,$this->campo)){  
            $this->addColumn($this->table,$this->campo, $this->integer(11));
        }
         migrationMenu::insertOption('Sustancias', '/masters/basico/index-sustancia','Materiales','snowflake-o');
       
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
       if($this->existsColumn($this->table,$this->campo)){  
            $this->dropColumn($this->table,$this->campo);
       }
       migrationMenu::deleteOption('Sustancias', '/masters/basico/index-sustancia');
       
    }
       
} 