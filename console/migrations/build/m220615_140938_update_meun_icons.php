<?php
use console\migrations\baseMigration;
use mdm\admin\models\Menu;

/**
 * Class m220615_140938_update_meun_icons
 */
class m220615_140938_update_meun_icons extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Menu::updateAll(['icon'=>'cubes'],['name'=>'Maestros']);
        Menu::updateAll(['icon'=>'industry'],['name'=>'Empresas']);
        Menu::updateAll(['icon'=>'calculator'],['name'=>'Unidades medida']);
        Menu::updateAll(['icon'=>'book'],['name'=>'Menu']);
        Menu::updateAll(['icon'=>'sitemap'],['name'=>'Opcion']);
        Menu::updateAll(['icon'=>'road'],['name'=>'Rutas']);
        Menu::updateAll(['icon'=>'thumbs-up'],['name'=>'Permisos']);
        Menu::updateAll(['icon'=>'codepen'],['name'=>'Reglas']);
        Menu::updateAll(['icon'=>'modx'],['name'=>'Roles']);
        Menu::updateAll(['icon'=>'sign-out'],['name'=>'Salir']);
        Menu::updateAll(['icon'=>'user-shield'],['name'=>'RBAC']);
        Menu::updateAll(['icon'=>'dropbox'],['name'=>'Maestros']);
        Menu::updateAll(['icon'=>'cog'],['name'=>'Config']);
        Menu::updateAll(['icon'=>'cogs'],['name'=>'Parametros']);
        Menu::updateAll(['icon'=>'user-plus'],['name'=>'Parametros']);
         Menu::updateAll(['icon'=>'user-lock'],['name'=>'Cambiar pass']);
          Menu::updateAll(['icon'=>'key'],['name'=>'User']);
           Menu::updateAll(['icon'=>'user-tag'],['name'=>'Asignaciones']);
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
    }

   
}
