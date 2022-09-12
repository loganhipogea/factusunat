<?php

use console\migrations\baseMigration;

/**
 * Handles the creation of table `{{%com_cotizaciones}}`.
 */
class m220909_125016_create_com_cotizaciones_table extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public $table='{{%com_cotizaciones}}';    
    public function safeUp()
    {
     
  
    
   if(!$this->existsTable($this->table)) {
            $this->createTable($this->table, [
            'id' => $this->primaryKey(),
           'numero' => $this->string(10)->append($this->collateColumn()),
           'serie' => $this->char(3)->append($this->collateColumn()),     
            'codsoc' => $this->char(1)->append($this->collateColumn()),
            'codcen' => $this->string(5)->append($this->collateColumn()), 
            'codcli' => $this->string(10)->append($this->collateColumn()),   
            'codcli1' => $this->string(10)->append($this->collateColumn()), 
            'estado' => $this->char(2)->append($this->collateColumn()),
            'descripcion' => $this->string(40)->append($this->collateColumn()),  
             'detalle_interno' => $this->text()->append($this->collateColumn()),
            'detalle_externo' => $this->text(40)->append($this->collateColumn()),
            'femision' => $this->char(10)->append($this->collateColumn()), 
            'validez' => $this->integer(3), 
             'codtra' => $this->string(6)->append($this->collateColumn()), 
            'n_direcc'=>$this->integer(11), 
             'codmon' => $this->char(3)->append($this->collateColumn()),    
                
        ], $this->collateTable());
            
        $this->putCombo($this->table,'serie',
                [
                    '100'=>'FABRICACION',
                    '200'=>'INGENIERIA',
                    '300'=>'CONSULTORIA',
                    '400'=>'MONTAJE',
                ]);
            
          $this->paramsFk=[
            $this->table,
            'codtra',
            '{{%trabajadores}}',
            'codigotra'
                    ];
            $this->addFk();
            
         /* $this->paramsFk=[
          $this->table,
            'n_direcc',
             '{{%direcciones}}',
            'id'
                    ];
            $this->addFk();*/
            
            
            $this->paramsFk=[
            $this->table,
            'codcen',
             '{{%centros}}',
            'codcen'
                    ];
            $this->addFk(); 
            
            
             $this->paramsFk=[
            $this->table,
            'codcli',
             '{{%clipro}}',
            'codpro'
                    ];
            $this->addFk(); 
            
            $this->paramsFk=[
            $this->table,
            'codcli1',
             '{{%clipro}}',
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
        if($this->existsTable($this->table)){
        $this->dropTable($this->table);
        }
    }
}
