<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%tableclases}}`.
 */
class m220723_032340_create_tableclases_table extends baseMigration
{
    const TABLE='{{%clasi_clases}}';
   //const TABLE_TRABAJADORES='{{%trabajadores}}';
    //const TABLE_CLIPRO='{{%clipro}}';
    
    // const TABLE_MOVIMIENTOS_BANCO='{{%sigi_movbanco}}';
    // const TABLE_TIPOMOV='{{%sigi_tipomov}}';
    //const TABLE_CARRERAS='{{%carreras}}';
    //const TABLE_CURSOS='{{%cursos}}';
    public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
           // 'id'=>$this->primaryKey(),
            'codigo' => $this->string(15)->notNull(),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'user_id'=>$this->integer(4)
            ],
           $this->collateTable());
       
      
        $this->addPrimaryKey(
                $this->generateNameFk($table),
               $table,
                'codigo');      
      
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
if ($this->existsTable(static::TABLE)) {
            $this->dropTable(static::TABLE);
        }
    }

    
}
