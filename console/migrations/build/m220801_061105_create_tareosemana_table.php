<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%tareosemana}}`.
 */
class m220801_061105_create_tareosemana_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%op_tareosemana}}';  
    const TABLE_TRABAJADORES='{{%trabajadores}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'codtra'=>$this->char(6)->notNull()->append($this->collateColumn()),
            'proc_id'=>$this->integer(11)->notNull(), 
            'semana'=>$this->integer(2)->notNull(),  
            'he'=>$this->decimal(7,2),  
            'h'=>$this->decimal(7,2),
            'hd'=>$this->decimal(7,2),
            'hf'=>$this->decimal(7,2),
            'hn'=>$this->decimal(7,2),
             'basicodiario'=>$this->decimal(10,2),
            'basico'=>$this->decimal(10,2), 
              'dominical'=>$this->decimal(10,2),    
            'extras'=>$this->decimal(10,2)->comment('MONTO SEMANAL POR HORAS EXTRAS Y FERIADOS '), 
            'total'=>$this->decimal(10,2), 
        ]);
        $this->paramsFk=[
            $this->table,
            'codtra',
           static::TABLE_TRABAJADORES,
            'codigotra'
                    ];
      
      $this->addFk();
      $this->paramsFk=[
            $this->table,
            'proc_id',
           static::TABLE_PROCESOS,
            'id'
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
