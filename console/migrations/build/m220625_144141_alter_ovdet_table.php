<?php
use console\migrations\baseMigration;
class m220625_144141_alter_ovdet_table extends baseMigration
{
   public $table='{{%com_ovdet}}';
    public function safeUp()
    {
       
       
       if(!$this->existsColumn($this->table, 'descripcion'))
        $this->addColumn($this->table, 'descripcion', $this->string(200));
       if(!$this->existsColumn($this->table, 'igv'))
        $this->addColumn($this->table, 'igv', $this->decimal(10,2));
       if(!$this->existsColumn($this->table, 'descuento'))
        $this->addColumn($this->table, 'descuento', $this->decimal(8,2));
       if(!$this->existsColumn($this->table, 'sunat_codtipoprecio'))
        $this->addColumn($this->table, 'sunat_codtipoprecio', $this->char(2));
       if(!$this->existsColumn($this->table, 'sunat_codtributo'))
        $this->addColumn($this->table, 'sunat_codtributo', $this->char(4));
       if(!$this->existsColumn($this->table, 'sunat_codtipoafectacion'))
         $this->addColumn($this->table, 'sunat_codtipoafectacion', $this->char(2));
       if(!$this->existsColumn($this->table, 'factura_id'))
         $this->addColumn($this->table, 'factura_id', $this->integer(11));
        //$this->addColumn($this->table, 'sunat_codtipoafectacion', $this->char(2));
     
    
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
      {      
            if($this->existsColumn($this->table, 'descripcion'))
            $this->dropColumn($this->table, 'descripcion');
            if($this->existsColumn($this->table, 'igv'))
            $this->dropColumn($this->table, 'igv');
             if($this->existsColumn($this->table, 'descuento'))
            $this->dropColumn($this->table, 'descuento');
             if($this->existsColumn($this->table, 'sunat_codtipoprecio'))
            $this->dropColumn($this->table, 'sunat_codtipoprecio');
              if($this->existsColumn($this->table, 'sunat_codtributo'))
            $this->dropColumn($this->table, 'sunat_codtributo');
              if($this->existsColumn($this->table, 'sunat_codtipoafectacion'))
            $this->dropColumn($this->table, 'sunat_codtipoafectacion');
              if($this->existsColumn($this->table, 'factura_id'))
            $this->dropColumn($this->table, 'factura_id');
              if($this->existsColumn($this->table, 'factura_id'))
             $this->addColumn($this->table, 'factura_id');
        
            //$this->dropColumn($this->table, 'sunat_codtipoafectacion');
           // $this->dropColumn($this->table, 'descripcion');
            //$this->dropColumn($this->table, 'descripcion');
       }
}

    

    