<?php

USE console\migrations\migrationMenu;

/**
 * Class m230427_132858_create_item_menu
 */
class m230427_132858_create_item_menu extends migrationMenu
{
   public function safeUp()
    {
         migrationMenu::insertOption('Almacen',null,'Logística','balance-scale');
         migrationMenu::insertOption('Transacciones',null,'/masters/transa/index','retweet');
         migrationMenu::insertOption('Crear mov','/mat/mat/crea-vale','Almacen','exchange');
         migrationMenu::insertOption('Transferir','/mat/mat/transferir-vale','Almacen','shekel');
         migrationMenu::insertOption('Revertir','/mat/mat/anular-vale','Almacen','undo');
         migrationMenu::insertOption('Stock','/mat/mat/index-stock','Almacen','dropbox');
         migrationMenu::insertOption('Kardex','/mat/mat/index-kardex','Almacen','bars');
         migrationMenu::insertOption('Almacenes','/masters/centros/index-almacenes','Almacen','industry');
        
          }
    
    public function safeDown()
    {
        
        
         migrationMenu::deleteOption('Transacciones',null,'/masters/transa/index','retweet');
         migrationMenu::deleteOption('Crear mov','/mat/mat/crea-vale','Almacen','exchange');
         migrationMenu::deleteOption('Transferir','/mat/mat/transferir-vale','Almacen','shekel');
         migrationMenu::deleteOption('Revertir','/mat/mat/anular-vale','Almacen','undo');
         migrationMenu::deleteOption('Stock','/mat/mat/index-stock','Almacen','dropbox');
         migrationMenu::deleteOption('Kardex','/mat/mat/index-kardex','Almacen');
          migrationMenu::deleteOption('Almacenes','/masters/centros/index-almacenes','Almacen');
         migrationMenu::deleteOption('Almacen',null,'Logística');
         
    }
}