<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%servicios_tarifad}}`.
 */
class m221228_144710_create_servicios_tarifad_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%servicios_tarifados}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codserv'=> $this->string(5)->append($this->collateColumn()), 
            'descripcion'=>$this->string(40)->append($this->collateColumn()),
             'detalle'=>$this->text()->append($this->collateColumn()),
            'codum'=>$this->string(4)->append($this->collateColumn()),
            'precio'=>$this->decimal(8,3),  
            'codmon'=>$this->string(5)->append($this->collateColumn())
        ],
            $this->collateTable());
      }
      
       $this->paramsFk=[
            $this->table,
            'codum',
            '{{%ums}}',
            'codum'
                    ];
            $this->addFk();
        $this->paramsFk=[
            $this->table,
            'codmon',
            '{{%monedas}}',
            'codmon'
                    ];
            $this->addFk();

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
