<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%contactocoti}}`.
 */
class m230123_145353_create_contactocoti_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
   public $table='{{%com_contactocoti}}';  
   
    public function safeUp()
    {
        if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'coti_id'=>$this->integer(11),
            'contacto_id'=>$this->integer(11),
            
            'prioridad'=>$this->integer(2),
            'send'=>$this->char(1),
            'codpro'=>$this->string(10),
        ], $this->collateTable());
        $this->paramsFk=[
            $this->table,
            'coti_id',
            '{{%com_cotizaciones}}',
            'id'
                    ];
            $this->addFk();     
            
        $this->paramsFk=[
            $this->table,
            'contacto_id',
            '{{%contactos}}',
            'id'
                    ];
            $this->addFk();    
        
        $this->paramsFk=[
            $this->table,
            'codpro',
            '{{%clipro}}',
            'codpro'
                    ];
            $this->addFk();   
        
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
