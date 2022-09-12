<?php
USE console\migrations\migrationMenu;
class m220909_233952_create_optionmenu_ofertas extends migrationMenu
{  
    public function safeUp()
    {
        migrationMenu::insertOption('Ofertas', '/com/coti/index-coti','Comercial','clone');
        migrationMenu::insertOption('Clasificacion',null,'Maestros','sitemap');
        migrationMenu::insertOption('Clases','/masters/clasi/index-clases','Clasificacion','cube');
        migrationMenu::insertOption('Atributos','/masters/clasi/index-atributos','Clasificacion','list');
        
    }   
    
    public function safeDown()
    {
          migrationMenu::deleteOption('Atributos','/masters/clasi/index-atributos','Clasificacion');
         migrationMenu::deleteOption('Clases','/masters/clasi/index-clases','Clasificacion');
       migrationMenu::deleteOption('Clasificacion',null,'Maestros');
       migrationMenu::deleteOption('Ofertas', '/com/coti/index-coti','Comercial');
       
        
    }

}