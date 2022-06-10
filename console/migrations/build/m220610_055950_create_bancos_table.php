<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%bancos}}`.
 */
class m220610_055950_create_bancos_table extends baseMigration
{
   
 const NAME_TABLE='{{%bancos}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
            'codbanco'=>$this->string(10)->notNull()->append($this->collateColumn()),
            'nombre' =>$this->string(40)->append($this->collateColumn()),
          'texto' => $this->text()->append($this->collateColumn()),
            //'ishome' => $this->char(1)->append($this->collateColumn()),
            'order'=> $this->integer(3),
             ],$this->collateTable());
         /*$this->addForeignKey($this->generateNameFk($table), $table,
              'codocu', static::NAME_TABLE_DOCUMENTOS,'codocu');*/
           }
    
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
