<?php
use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%opotra}}`.
 */
class m220721_011409_create_trabajadores_table extends baseMigration
{

    const NAME_TABLE='{{%trabajadores}}';
    //const NAME_TABLE_SOCIEDADES='{{%sociedades}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

$table=static::NAME_TABLE;
if(!$this->existsTable($table)){
        $this->createTable($table, [
             'id'=>$this->primaryKey(),
            'codigotra' => $this->string(6)->notNull()->append($this->collateColumn()),
            'ap' => $this->string(40)->notNull()->append($this->collateColumn()), 
            'am'=>$this->string(40)->notNull()->append($this->collateColumn()), 
            'nombres'=>$this->string(40)->notNull()->append($this->collateColumn()),
            'dni' => $this->string(12)->append($this->collateColumn()),
             'ppt' => $this->string(10)->append($this->collateColumn()),
              'pasaporte' => $this->string(10)->append($this->collateColumn()),
           'codpuesto'=>$this->string(3)->notNull()->append($this->collateColumn()),
            'cumple'=>$this->char(10)->notNull()->append($this->collateColumn()),
            'fecingreso'=>$this->char(10)->append($this->collateColumn()),
            'domicilio'=>$this->string(73)->append($this->collateColumn()),
             'telfijo'=>$this->string(13)->append($this->collateColumn()),
            'telmoviles'=>$this->string(30)->append($this->collateColumn()),
            'referencia'=>$this->string(30)->append($this->collateColumn()),
             ], $this->collateTable());
      
         $this->createIndex(uniqid('k_codigotra'), static::NAME_TABLE, 'codigotra',true);
       // $this->createIndex(uniqid('k_dni'), static::NAME_TABLE, 'dni');
        $this->createIndex(uniqid('k_ap'), static::NAME_TABLE, 'ap');
        $this->createIndex(uniqid('k_am'), static::NAME_TABLE, 'am');
        $this->createIndex(uniqid('k_nombres'), static::NAME_TABLE, 'nombres');
          $this->createIndex(uniqid('k_nombrescompletos'), static::NAME_TABLE, ['nombres','ap','am']);
    
    $this->putCombo($table, 'codpuesto',
            [
                'OPERARIO',
                'OFICIAL',
                'AYUDANTE',
                'RESIDENTE',
                'JEFE DE OBRA',
                'PREVENCIONISTA',
                'JEFE DE OPERACIONES',
                'SUPERVISOR',
                
              
                ]);      
  }
    
    
    
    }
	

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        if ($this->db->schema->getTableSchema(static::NAME_TABLE, true) !== null) {
            $this->dropTable(static::NAME_TABLE);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190106_063220_create_table_centros cannot be reverted.\n";

        return false;
    }
    */
}
