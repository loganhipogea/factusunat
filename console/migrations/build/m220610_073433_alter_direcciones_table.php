<?php

use console\migrations\baseMigration;
use yii\base\Exception;
/**
 * Class m220610_073433_alter_direcciones_table
 */
class m220610_073433_alter_direcciones_table extends baseMigration
{
     
    const NAME_TABlE_DIRECCIONES='{{%direcciones}}';
    const NAME_TABlE_CLIPRO='{{%clipro}}';
    public $paramsFk=[
            self::NAME_TABlE_DIRECCIONES,
            'codpro',
            self::NAME_TABlE_CLIPRO,
            'codpro'
                ];
    public function safeUp()
    {
        
        // print_r($this->paramsFk);die();
         /* Agregando una columna a la tabla Direcciones
         * con su respectiva llave foranes
         */
        $table=$this->paramsFk[0];
        if($this->existsTable($table)) {
          if(!$this->existsColumn($table, 'codpro')){
            $this->addColumn($table,
                 'codpro', 
                 $this->char(6)->notNull()->append($this->collateColumn())
                 );
          }
            $this->addFk();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table=static::NAME_TABlE_DIRECCIONES;
      if($this->existsTable($table)) {
            $this->dropFk();
            $this->dropColumn($table,'codpro');
          }
            
     }
 
    

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M190508053817Alter_table_direcciones_add_column cannot be reverted.\n";

        return false;
    }
    */
}
