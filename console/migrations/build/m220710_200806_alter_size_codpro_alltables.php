<?php
use console\migrations\baseMigration;
class m220710_200806_alter_size_codpro_alltables extends baseMigration
{
    public $table='{{%clipro}}';
    public $elements=[
           '{{%centros}}',
           '{{%contactos}}',
           '{{%cuentas}}',
           '{{%direcciones}}',
           '{{%maestroclipro}}',
           '{{%objcli}}',
           ];
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
       $this->dropFksNow();
       $this->alterColumn($this->table,'codpro', $this->string(10));
        foreach($this->elements as $element){
         $this->alterColumn($element, 'codpro',$this->string(10));
           }  
       $this->restoreFksNow();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropFksNow();
        foreach($this->elements as $element){
         $this->alterColumn($element, 'codpro',$this->char(6));
           } 
        $this->restoreFksNow();
    }

   private function dropFksNow(){
        /*borrando las llaves foraneas primero*/
      
       foreach($this->elements as $element){
         $this->paramsFk=[
            $element,
            'codpro',
            $this->table,
            'codpro'
        ];       
        $this->dropFk();  
       }
   }
   
   private function restoreFksNow(){
       /*
        * Volviendo a crear los fks
        */
       foreach($this->elements as $element){
         $this->paramsFk=[
            $element,
            'codpro',
            $this->table,
            'codpro'
        ];       
        $this->addFk(); 
       } 
   }
}
