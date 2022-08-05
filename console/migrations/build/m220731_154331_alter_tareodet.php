<?php
use console\migrations\baseMigration;
class m220731_154331_alter_tareodet extends baseMigration
{
    
    public function safeUp()
    {
         $this->paramsFk=[
            '{{%op_tareodet}}',
            'tarifa_id',
           '{{%op_planestarifa}}',
            'id'
                    ];
        $this->dropFk();
         $this->paramsFk=[
            '{{%op_tareodet}}',
            'tarifa_id',
           '{{%op_tarifa_hombre}}',
            'id'
                    ];
       $this->addFk();
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
          $this->paramsFk=[
            '{{%op_tareodet}}',
            'tarifa_id',
           '{{%op_tarifa_hombre}}',
            'id'
                    ];
         $this->dropFk();  
           $this->paramsFk=[
            '{{%op_tareodet}}',
            'tarifa_id',
           '{{%op_planestarifa}}',
            'id'
                    ];
       $this->addFk();
        
    }
}