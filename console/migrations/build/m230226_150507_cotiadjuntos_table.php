<?php
use console\migrations\baseMigration;

/**
 * Class m230226_150507_cotiadjuntos_table
 */
class m230226_150507_cotiadjuntos_table extends baseMigration
{
     /**
     * {@inheritdoc}
     */
    public $table='{{%com_cotiadjuntos}}';    
    public function safeUp()
    {
   if(!$this->existsTable($this->table)) {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
             'coti_id'=>$this->integer(11), 
            //'coti_id'=>$this->integer(11),
             'descripcion'=>$this->string(40), 
              'orden'=>$this->integer(2),
              'detalle'=>$this->text(),
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
