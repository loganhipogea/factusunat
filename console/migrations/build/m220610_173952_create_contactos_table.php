<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%contactos}}`.
 */
class m220610_173952_create_contactos_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%contactos}}';
    public $paramsFk=[];
    
    const NAME_TABLE_CLIPRO='{{%clipro}}';
    public function safeUp()
    {
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($this->table)) {
       $this->createTable($this->table, [
            'id'=>$this->primaryKey(),
            'nombres'=>$this->string(60)->append($this->collateColumn()),  
               'moviles'=>$this->string(40)->append($this->collateColumn()),
            'mail'=>$this->string(25)->append($this->collateColumn()),  
               //'mail1'=>$this->string(30)->append($this->collateColumn()),
             'codpro'=>$this->char(6)->append($this->collateColumn()),
            'tipodoc'=>$this->string(3)->append($this->collateColumn()),
            'numdoc'=>$this->char(6)->append($this->collateColumn()),
           // 'fenac'=>$this->char(5)->append($this->collateColumn()),
            /// 'latitud'=>$this->string(15)->append($this->collateColumn()),
            // 'meridiano'=>$this->string(15)->append($this->collateColumn()),],
               
            ],
           $this->collateTable());
        $this->paramsFk=[
            $this->table,
            'codpro',
            self::NAME_TABLE_CLIPRO,
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
   if ($this->db->schema->getTableSchema($this->table, true) !== null) {
         
       $this->dropTable($this->table);
            
        }
    }

   
}
