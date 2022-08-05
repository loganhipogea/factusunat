<?php

use console\migrations\baseMigration;

/**
 * Class m220801_225113_viewtareosemana_table
 */
class m220801_225113_viewtareosemana_table extends baseMigration
{
  const NAME_VIEW='{{%op_vw_tareosemana}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {         
         $vista=static::NAME_VIEW; 
        if($this->existsTable($vista))
         $this->dropView($vista);
        
         $comando= $this->db->createCommand();       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
     'a.proc_id','a.codtra','a.semana',
     'b.ap','b.nombres','b.codpuesto',
     'c.numero','c.descripcion',
     'd.costohora',  
     'e.codigo' , 'e.porc_dominical' , 'e.porc_feriado' ,
     'e.porc_nocturno' , 'e.porc_refrigerio' ,
      'e.porc_hextras' , 'e.nhoras' ,  
     'sum(a.costo) as costo','sum(a.htotales) as htotales',
     'sum(a.hextras) as hextras','sum(a.basico) as basico',
     'sum(a.dominical) as dominical','sum(a.adicional) as adicional',    
         ])
    ->from(['a'=>'{{%op_tareodet}}'])->
     innerJoin('{{%trabajadores}} b', 'b.codigotra=a.codtra')->
     innerJoin('{{%op_procesos}} c', 'c.id=a.proc_id')->
     innerJoin('{{%op_tarifa_hombre}} d', 'a.codtra=d.codtra')->
     innerJoin('{{%op_planestarifa}} e', 'e.id=d.tarifa_id')->           
     groupBy(['a.proc_id','a.codtra','a.semana',
      'd.costohora',  
     'e.codigo' , 'e.porc_dominical' , 'e.porc_feriado' ,
     'e.porc_nocturno' , 'e.porc_refrigerio' ,
      'e.porc_hextras' , 'e.nhoras' ,      
     'b.ap','b.nombres','b.codpuesto',
     'c.numero','c.descripcion',]) 
                )->execute();
    
}
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }

    
}
