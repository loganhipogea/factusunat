<?php
use console\migrations\baseMigration;
class m220809_152005_create_profile_table extends baseMigration
{ /**
     * {@inheritdoc}
     */
    const NAME_TABlE='{{%profile}}';
    const NAME_TABlE_USER='{{%user}}';
    public function safeUp()
    {
        $table=static::NAME_TABlE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
            'tipo'=>$this->char(2),
           'codtra'=>$this->char(6),
            'user_id'=>$this->integer(11),
            'duration'=>$this->integer(11),
             'durationabsolute'=>$this->integer(11),
            'names' => $this->string(60)->append($this->collateColumn()),
            'photo' => $this->text()->append($this->collateColumn()),
            'detalle'=>$this->text()->append($this->collateColumn()),
            
            ],
           $this->collateTable());
       
           $this->putCombo($table,'tipo',['10'=>'TRABAJADOR','20'=>'ADMINISTRADOR','30'=>'CLIENTE']);
     
        }
        
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
   if ($this->db->schema->getTableSchema(static::NAME_TABlE, true) !== null) {
            $this->dropTable(static::NAME_TABlE);
        }
    }

   
}
