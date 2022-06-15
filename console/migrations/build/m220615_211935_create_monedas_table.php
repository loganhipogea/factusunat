<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%monedas}}`.
 */
class m220615_211935_create_monedas_table extends baseMigration
{
   
 const NAME_TABLE='{{%monedas}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'codmon'=>$this->string(5)->notNull()->append($this->collateColumn()),
            'desmon'=>$this->string(15)->notNull()->append($this->collateColumn()),
            'activa' =>$this->string(40)->append($this->collateColumn()),         
             'simbolo' =>$this->string(3)->append($this->collateColumn()),  
         'centimo' =>$this->string(50)->append($this->collateColumn()),         
             
        ],$this->collateTable());
      $this->addPrimaryKey($this->generateNameFk($table), $table, 'codmon');
         /*$this->addForeignKey($this->generateNameFk($table), $table,
              'codocu', static::NAME_TABLE_DOCUMENTOS,'codocu');*/
           }
        \Yii::$app->db->createCommand()->
             batchInsert(static::NAME_TABLE,
             ['codmon','desmon','activa','simbolo'],
                     [
                        ['PEN', 'SOLES' ,'1','S/.'],
                        ['USD', 'DOLARES' ,'1','$/.'],
                                   
                    ]
                     
                     )->execute();
           
           
    
    }

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table=static::NAME_TABLE; 
       if ($this->existsTable($table)){
            $this->dropTable($table);
        }

    }
}
