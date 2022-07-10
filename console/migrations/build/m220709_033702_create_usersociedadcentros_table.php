<?php
use console\migrations\baseMigration;
class m220709_033702_create_usersociedadcentros_table extends baseMigration
{   
    public $table='{{%user_sociedades}}';    
    public function safeUp()
    {
        
    
   if(!$this->existsTable($this->table)) {
      $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(11)->notNull(),
            'codsoc'=>$this->string(3)->notNull()->append($this->collateColumn()),
            'codcen'=>$this->string(5)->notNull()->append($this->collateColumn()),
            'activo'=>$this->char(1),
        ],$this->collateTable());
      }
       $this->paramsFk=[
            $this->table,
            'user_id',
            '{{%user}}',
            'id'
        ];
       /* $this->addFk();
        $this->paramsFk=[
            $this->table,
            'codcen',
            '{{%centros}}',
            'id'
        ];
        $this->addFk();*/
      
    }
     
    public function safeDown()
    {
        $this->paramsFk=[
            $this->table,
            'user_id',
            '{{%user}}',
            'id'
        ];
        $this->dropFk();
        /*$this->paramsFk=[
            $this->table,
            'codcen',
            '{{%centros}}',
            'id'
        ];
        $this->dropFk();*/
        if($this->existsTable($this->table)){
          $this->dropTable($this->table);
        }
        
    }
}
